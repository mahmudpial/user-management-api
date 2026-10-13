<?php

// app/Http/Controllers/Api/UserController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                'message' => 'Please verify your email address to access your member dashboard.',
            ], 403);
        }

        $orders = ProjectOrder::query()
            ->whereRaw('LOWER(customer_email) = ?', [mb_strtolower($user->email)])
            ->with(['project:id,title,slug', 'pricingTier:id,tier_name,file_path'])
            ->latest()
            ->get();

        $completedOrders = $orders->where('payment_status', 'completed');

        return response()->json([
            'status' => true,
            'data' => [
                'summary' => [
                    'total_orders' => $orders->count(),
                    'completed_orders' => $completedOrders->count(),
                    'pending_orders' => $orders->where('payment_status', 'pending')->count(),
                    'downloads' => $completedOrders->sum('download_count'),
                ],
                'orders' => $orders->map(function (ProjectOrder $order): array {
                    $filePath = $order->pricingTier?->file_path;
                    $canDownload = $order->payment_status === 'completed'
                        && filled($filePath)
                        && Storage::disk('local')->exists($filePath);

                    return [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'project' => [
                            'title' => $order->project->title,
                            'slug' => $order->project->slug,
                        ],
                        'license' => $order->pricingTier?->tier_name,
                        'amount' => $order->amount,
                        'currency' => strtoupper($order->currency),
                        'payment_status' => $order->payment_status,
                        'download_count' => $order->download_count,
                        'can_download' => $canDownload,
                        'created_at' => $order->created_at,
                    ];
                })->values(),
            ],
        ]);
    }

    public function downloadOrder(Request $request, ProjectOrder $order)
    {
        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                'message' => 'Please verify your email address to download purchases.',
            ], 403);
        }

        if (! hash_equals(mb_strtolower($user->email), mb_strtolower($order->customer_email))) {
            return response()->json(['status' => false, 'message' => 'Order not found.'], 404);
        }

        if ($order->payment_status !== 'completed') {
            return response()->json(['status' => false, 'message' => 'Payment has not been completed.'], 403);
        }

        $order->loadMissing(['project:id,slug', 'pricingTier:id,file_path']);
        $filePath = $order->pricingTier?->file_path;
        $disk = Storage::disk('local');

        if (blank($filePath) || ! $disk->exists($filePath)) {
            return response()->json(['status' => false, 'message' => 'The project download is unavailable.'], 404);
        }

        $order->increment('download_count');

        return $disk->download($filePath, $order->project->slug.'-source-code.zip');
    }

    // ── Get profile ───────────────────────────────────────────
    public function profile()
    {
        return response()->json([
            'status' => true,
            'user' => auth()->user(),
        ]);
    }

    // ── Update profile ────────────────────────────────────────
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'phone' => 'sometimes|string|max:20',
            'profile_image' => 'sometimes|url',
        ]);

        $user->update($request->only('name', 'phone', 'profile_image'));

        return response()->json([
            'status' => true,
            'message' => 'Profile updated.',
            'user' => $user->fresh(),
        ]);
    }

    // ── Change password ───────────────────────────────────────
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully.',
        ]);
    }
}
