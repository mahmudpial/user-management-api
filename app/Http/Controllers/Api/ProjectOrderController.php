<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InitiateProjectOrderRequest;
use App\Models\ProjectOrder;
use App\Models\ProjectPricingTier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectOrderController extends Controller
{
    public function initiate(InitiateProjectOrderRequest $request)
    {
        $tier = ProjectPricingTier::query()
            ->with('project')
            ->findOrFail($request->integer('pricing_tier_id'));

        if (
            ! $tier->project->is_published
            || blank($tier->file_path)
            || ! Storage::disk('local')->exists($tier->file_path)
        ) {
            return response()->json([
                'status' => false,
                'message' => 'This project tier is not available for purchase yet.',
            ], 422);
        }

        $token = Str::random(64);
        $order = DB::transaction(fn () => ProjectOrder::create([
            'order_number' => 'ORD-'.Str::upper((string) Str::ulid()),
            'project_id' => $tier->project_id,
            'pricing_tier_id' => $tier->id,
            'customer_name' => $request->validated('customer_name'),
            'customer_email' => $request->validated('customer_email'),
            'amount' => $tier->discount_price ?? $tier->price,
            'payment_gateway' => $request->validated('payment_gateway'),
            'payment_status' => 'pending',
            'download_token' => hash('sha256', $token),
        ]));

        return response()->json([
            'status' => true,
            'data' => [
                'order' => $order->load(['project:id,title,slug', 'pricingTier:id,tier_name']),
                'checkout' => [
                    'provider' => $order->payment_gateway,
                    'merchant_reference' => $order->order_number,
                    'amount' => $order->amount,
                    'currency' => config('premium-projects.currency', 'USD'),
                    'payment_status' => $order->payment_status,
                    'checkout_url' => null,
                    'provider_session_created' => false,
                ],
                'download_url' => route('premium-projects.download', ['download_token' => $token]),
            ],
        ], 201);
    }

    public function download(string $download_token)
    {
        $order = ProjectOrder::query()
            ->where('download_token', hash('sha256', $download_token))
            ->with(['project:id,slug', 'pricingTier:id,file_path'])
            ->first();

        if (! $order) {
            return response()->json(['status' => false, 'message' => 'Download link is invalid.'], 404);
        }

        if ($order->payment_status !== 'completed') {
            return response()->json(['status' => false, 'message' => 'Payment has not been completed.'], 403);
        }

        if (! $order->token_expires_at || $order->token_expires_at->isPast()) {
            return response()->json(['status' => false, 'message' => 'Download link has expired.'], 410);
        }

        $filePath = $order->pricingTier->file_path;
        $disk = Storage::disk('local');

        if (blank($filePath) || ! $disk->exists($filePath)) {
            return response()->json(['status' => false, 'message' => 'The project download is unavailable.'], 404);
        }

        $order->increment('download_count');

        return $disk->download($filePath, $order->project->slug.'-source-code.zip');
    }
}
