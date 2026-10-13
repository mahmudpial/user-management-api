<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCheckoutSessionRequest;
use App\Http\Requests\VerifyCheckoutSessionRequest;
use App\Models\PaymentLog;
use App\Models\ProjectOrder;
use App\Models\ProjectPricingTier;
use App\Services\StripeCheckoutFulfillment;
use App\Services\StripeCheckoutGateway;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    public function __construct(private readonly StripeCheckoutGateway $stripe) {}

    public function createCheckoutSession(CreateCheckoutSessionRequest $request): JsonResponse
    {
        $user = $request->user();
        if (! $user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email address before checkout.',
            ], 403);
        }

        if (! config('services.stripe.checkout_enabled')) {
            return response()->json([
                'success' => false,
                'message' => 'Checkout is temporarily unavailable while payment setup is being completed. Please check back soon.',
            ], 503);
        }

        $tier = ProjectPricingTier::query()->with('project')->findOrFail($request->integer('pricing_tier_id'));
        $filePath = $tier->file_path;

        if (
            ! $tier->project->is_published
            || blank($filePath)
            || ! Storage::disk('local')->exists($filePath)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This project license is not currently available for purchase.',
            ], 422);
        }

        $currency = strtolower((string) config('services.stripe.currency', 'usd'));
        if (! in_array($currency, ['usd', 'bdt'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'The configured Stripe currency is not supported by this checkout.',
            ], 500);
        }

        $amount = (string) ($tier->discount_price ?? $tier->price);
        $unitAmount = (int) round(((float) $amount) * 100);
        if ($unitAmount < 1) {
            return response()->json([
                'success' => false,
                'message' => 'The configured price must be at least one minor currency unit.',
            ], 422);
        }

        $order = DB::transaction(fn (): ProjectOrder => ProjectOrder::create([
            'order_number' => 'ORD-'.Str::upper((string) Str::ulid()),
            'project_id' => $tier->project_id,
            'pricing_tier_id' => $tier->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'amount' => $amount,
            'currency' => $currency,
            'payment_gateway' => 'stripe',
            'payment_status' => 'pending',
        ]));

        try {
            $session = $this->stripe->createSession([
                'mode' => 'payment',
                'success_url' => config('services.stripe.success_url'),
                'cancel_url' => rtrim((string) config('services.stripe.cancel_url'), '?')
                    .'?'.http_build_query(['order_number' => $order->order_number]),
                'customer_email' => $order->customer_email,
                'client_reference_id' => (string) $order->id,
                'metadata' => [
                    'order_id' => (string) $order->id,
                    'order_number' => $order->order_number,
                    'project_id' => (string) $order->project_id,
                    'pricing_tier_id' => (string) $tier->id,
                    'customer_email' => $order->customer_email,
                ],
                'line_items' => [[
                    'quantity' => 1,
                    'price_data' => [
                        'currency' => $currency,
                        'unit_amount' => $unitAmount,
                        'product_data' => [
                            'name' => $tier->project->title.' — '.$tier->tier_name,
                            'description' => Str::limit($tier->project->summary, 500),
                        ],
                    ],
                ]],
            ], 'project-order-'.$order->order_number);
        } catch (ApiErrorException $exception) {
            DB::transaction(function () use ($exception, $order): void {
                $order->forceFill(['payment_status' => 'failed'])->save();
                PaymentLog::create([
                    'order_id' => $order->id,
                    'gateway' => 'stripe',
                    'event_type' => 'checkout.session.create_failed',
                    'payload' => ['stripe_error_code' => $exception->getStripeCode()],
                    'status' => 'failed',
                ]);
            });

            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'We could not start checkout. Please try again.',
            ], 502);
        }

        $order->forceFill(['stripe_checkout_session_id' => $session->id])->save();

        return response()->json([
            'success' => true,
            'data' => [
                'order_number' => $order->order_number,
                'checkout_url' => $session->url,
                'session_id' => $session->id,
            ],
        ], 201);
    }

    public function verifySession(
        VerifyCheckoutSessionRequest $request,
        StripeCheckoutFulfillment $fulfillment
    ): JsonResponse {
        $user = $request->user();
        if (! $user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email address to access this order.',
            ], 403);
        }

        try {
            $session = $this->stripe->retrieveSession((string) $request->validated('session_id'));
        } catch (ApiErrorException $exception) {
            if ($exception->getHttpStatus() === 404) {
                return response()->json(['success' => false, 'message' => 'Checkout session not found.'], 404);
            }

            report($exception);

            return response()->json(['success' => false, 'message' => 'Unable to verify payment right now.'], 502);
        }

        $orderId = $session->metadata->order_id ?? null;
        $order = $orderId ? ProjectOrder::query()->with(['project', 'pricingTier'])->find($orderId) : null;

        if (! $order || $order->stripe_checkout_session_id !== $session->id) {
            return response()->json(['success' => false, 'message' => 'Checkout session does not match an order.'], 404);
        }

        if (! hash_equals(mb_strtolower($user->email), mb_strtolower($order->customer_email))) {
            return response()->json(['success' => false, 'message' => 'Checkout session does not match an order.'], 404);
        }

        if ($session->payment_status === 'paid') {
            $fulfillment->processSession(
                $session,
                'verify_'.$session->id,
                'checkout.session.verified',
                $session->toArray(),
            );
            $order->refresh()->load(['project', 'pricingTier']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'order_number' => $order->order_number,
                'project' => $order->project->title,
                'license' => $order->pricingTier->tier_name,
                'amount' => $order->amount,
                'currency' => strtoupper($order->currency),
                'payment_status' => $order->payment_status,
                'download_url' => $order->payment_status === 'completed'
                    ? route('user.orders.download', ['order' => $order->id])
                    : null,
            ],
        ], $order->payment_status === 'completed' ? 200 : 202);
    }
}
