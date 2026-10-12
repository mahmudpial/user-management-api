<?php

namespace App\Services;

use App\Events\OrderPaid;
use App\Models\PaymentLog;
use App\Models\ProjectOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Event;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class StripeCheckoutFulfillment
{
    public function processSession(Session $session, string $eventId, string $eventType, array $payload): ?ProjectOrder
    {
        return DB::transaction(function () use ($session, $eventId, $eventType, $payload): ?ProjectOrder {
            $existingLog = PaymentLog::query()
                ->where('gateway', 'stripe')
                ->where('gateway_event_id', $eventId)
                ->lockForUpdate()
                ->first();

            if ($existingLog) {
                return $existingLog->order?->fresh(['project', 'pricingTier']);
            }

            $orderId = $session->metadata->order_id ?? null;
            $order = $orderId
                ? ProjectOrder::query()->whereKey($orderId)->lockForUpdate()->first()
                : null;

            if (! $order) {
                PaymentLog::create([
                    'gateway' => 'stripe',
                    'gateway_event_id' => $eventId,
                    'event_type' => $eventType,
                    'payload' => $payload,
                    'status' => 'unmatched',
                ]);

                return null;
            }

            $this->assertSessionMatchesOrder($session, $order);

            $log = PaymentLog::create([
                'order_id' => $order->id,
                'gateway' => 'stripe',
                'gateway_event_id' => $eventId,
                'event_type' => $eventType,
                'payload' => $payload,
                'status' => 'received',
            ]);

            if ($order->payment_status === 'completed') {
                $log->update(['status' => 'already_fulfilled']);

                return $order->load(['project', 'pricingTier']);
            }

            if ($order->payment_status !== 'pending' || $session->payment_status !== 'paid') {
                $log->update(['status' => 'not_paid']);

                return $order->load(['project', 'pricingTier']);
            }

            $tier = $order->pricingTier;
            if (blank($tier->file_path) || ! Storage::disk('local')->exists($tier->file_path)) {
                throw new UnprocessableEntityHttpException('The purchased project archive is unavailable.');
            }

            $plainToken = Str::random(64);
            $order->forceFill([
                'payment_status' => 'completed',
                'transaction_id' => $this->paymentIntentId($session),
                'download_token' => hash('sha256', $plainToken),
                'download_token_encrypted' => $plainToken,
                'token_expires_at' => now()->addDays((int) config('services.stripe.download_token_days', 7)),
            ])->save();

            $log->update(['status' => 'processed']);

            event(new OrderPaid(
                $order->load(['project', 'pricingTier']),
                route('premium-projects.download', ['download_token' => $plainToken]),
            ));

            return $order->fresh(['project', 'pricingTier']);
        }, attempts: 3);
    }

    public function recordIgnoredEvent(Event $event): void
    {
        PaymentLog::firstOrCreate(
            ['gateway' => 'stripe', 'gateway_event_id' => $event->id],
            [
                'event_type' => $event->type,
                'payload' => $event->toArray(),
                'status' => 'ignored',
            ],
        );
    }

    public function recordRejectedEvent(Event $event): void
    {
        PaymentLog::firstOrCreate(
            ['gateway' => 'stripe', 'gateway_event_id' => $event->id],
            [
                'event_type' => $event->type,
                'payload' => $event->toArray(),
                'status' => 'rejected',
            ],
        );
    }

    private function assertSessionMatchesOrder(Session $session, ProjectOrder $order): void
    {
        $metadata = $session->metadata;
        $expectedCents = (int) round(((float) $order->amount) * 100);
        $actualCurrency = strtolower((string) $session->currency);

        if (
            $session->mode !== 'payment'
            ||
            ($metadata->order_number ?? null) !== $order->order_number
            || (string) ($metadata->project_id ?? '') !== (string) $order->project_id
            || (string) ($metadata->pricing_tier_id ?? '') !== (string) $order->pricing_tier_id
            || strtolower((string) ($metadata->customer_email ?? '')) !== strtolower($order->customer_email)
            || (string) $session->id !== (string) $order->stripe_checkout_session_id
            || (int) $session->amount_total !== $expectedCents
            || $actualCurrency !== strtolower($order->currency)
        ) {
            throw new UnprocessableEntityHttpException('The Stripe Checkout session does not match the pending order.');
        }
    }

    private function paymentIntentId(Session $session): ?string
    {
        $paymentIntent = $session->payment_intent;

        if (is_string($paymentIntent)) {
            return $paymentIntent;
        }

        return is_object($paymentIntent) ? ($paymentIntent->id ?? null) : null;
    }
}
