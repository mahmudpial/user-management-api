<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePremiumProjectRequest;
use App\Http\Requests\StoreProjectPricingTierRequest;
use App\Http\Requests\UpdatePremiumProjectRequest;
use App\Http\Requests\UpdateProjectOrderPaymentRequest;
use App\Http\Requests\UpdateProjectPricingTierRequest;
use App\Models\PremiumProject;
use App\Models\ProjectOrder;
use App\Models\ProjectPricingTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectManagementController extends Controller
{
    public function index()
    {
        $projects = PremiumProject::query()
            ->with(['pricingTiers' => fn ($query) => $query->orderBy('id')])
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return response()->json(['status' => true, 'data' => $projects]);
    }

    public function show(PremiumProject $project)
    {
        return response()->json([
            'status' => true,
            'data' => $project->load(['pricingTiers' => fn ($query) => $query->orderBy('id')]),
        ]);
    }

    public function store(StorePremiumProjectRequest $request)
    {
        $data = $request->validated();
        unset($data['thumbnail']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_url'] = $this->storeUploadedFile($request, 'thumbnail', 'premium-projects/thumbnails', 'public');
        }

        $project = PremiumProject::create($data);

        return response()->json(['status' => true, 'data' => $project], 201);
    }

    public function update(UpdatePremiumProjectRequest $request, PremiumProject $project)
    {
        $data = $request->validated();
        unset($data['thumbnail']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_url'] = $this->storeUploadedFile($request, 'thumbnail', 'premium-projects/thumbnails', 'public');
        }

        $project->update($data);

        return response()->json(['status' => true, 'data' => $project->fresh()]);
    }

    public function destroy(PremiumProject $project)
    {
        if ($project->orders()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Projects with order history cannot be deleted.',
            ], 409);
        }

        $sourcePaths = $project->pricingTiers()->whereNotNull('file_path')->pluck('file_path')->all();
        $project->delete();

        foreach (array_unique($sourcePaths) as $path) {
            $this->deleteFileIfUnused($path);
        }

        return response()->json(['status' => true, 'message' => 'Premium project deleted.']);
    }

    public function pricingTiers(PremiumProject $project)
    {
        return response()->json([
            'status' => true,
            'data' => $project->pricingTiers()->orderBy('id')->get(),
        ]);
    }

    public function showPricingTier(PremiumProject $project, ProjectPricingTier $tier)
    {
        abort_unless($tier->project_id === $project->id, 404);

        return response()->json(['status' => true, 'data' => $tier]);
    }

    public function storePricingTier(StoreProjectPricingTierRequest $request, PremiumProject $project)
    {
        $data = $request->validated();
        unset($data['source_code_file']);
        $data['billing_type'] = $data['billing_type'] ?? 'one_time';

        if ($request->hasFile('source_code_file')) {
            $data['file_path'] = $this->storeUploadedFile($request, 'source_code_file', 'premium-projects/source-codes', 'local');
        }

        $tier = $project->pricingTiers()->create($data);

        return response()->json(['status' => true, 'data' => $tier], 201);
    }

    public function updatePricingTier(UpdateProjectPricingTierRequest $request, PremiumProject $project, ProjectPricingTier $tier)
    {
        abort_unless($tier->project_id === $project->id, 404);

        $data = $request->validated();
        unset($data['source_code_file']);
        $oldFilePath = $tier->file_path;

        if ($request->hasFile('source_code_file')) {
            $data['file_path'] = $this->storeUploadedFile($request, 'source_code_file', 'premium-projects/source-codes', 'local');
        }

        $tier->update($data);

        if ($oldFilePath && isset($data['file_path']) && $oldFilePath !== $data['file_path']) {
            $this->deleteFileIfUnused($oldFilePath, $tier->id);
        }

        return response()->json(['status' => true, 'data' => $tier->fresh()]);
    }

    public function destroyPricingTier(PremiumProject $project, ProjectPricingTier $tier)
    {
        abort_unless($tier->project_id === $project->id, 404);

        if ($tier->orders()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Pricing tiers with order history cannot be deleted.',
            ], 409);
        }

        $filePath = $tier->file_path;
        $tier->delete();

        if ($filePath) {
            $this->deleteFileIfUnused($filePath);
        }

        return response()->json(['status' => true, 'message' => 'Pricing tier deleted.']);
    }

    public function orders(Request $request)
    {
        $orders = ProjectOrder::query()
            ->with(['project:id,title,slug', 'pricingTier:id,tier_name'])
            ->when($request->filled('payment_status'), fn ($query) => $query->where('payment_status', $request->string('payment_status')))
            ->when($request->filled('payment_gateway'), fn ($query) => $query->where('payment_gateway', $request->string('payment_gateway')))
            ->latest()
            ->paginate(min(max($request->integer('per_page', 20), 1), 100));

        return response()->json(['status' => true, 'data' => $orders]);
    }

    public function updateOrderPayment(UpdateProjectOrderPaymentRequest $request, ProjectOrder $order)
    {
        if ($order->payment_gateway === 'stripe') {
            return response()->json([
                'status' => false,
                'message' => 'Stripe orders can only be marked paid by a verified Stripe event.',
            ], 409);
        }

        $updatedOrder = DB::transaction(function () use ($request, $order): ?ProjectOrder {
            $lockedOrder = ProjectOrder::query()->lockForUpdate()->findOrFail($order->id);

            if ($lockedOrder->payment_status !== 'pending') {
                return null;
            }

            $paymentUpdate = $request->validated();

            if ($paymentUpdate['payment_status'] === 'completed') {
                $paymentUpdate['token_expires_at'] = now()->addDays((int) config('premium-projects.download_token_days', 7));
            }

            $lockedOrder->update($paymentUpdate);

            return $lockedOrder->fresh();
        });

        if (! $updatedOrder) {
            return response()->json([
                'status' => false,
                'message' => 'Only pending orders can be updated.',
            ], 409);
        }

        return response()->json(['status' => true, 'data' => $updatedOrder]);
    }

    private function storeUploadedFile(Request $request, string $field, string $directory, string $disk): string
    {
        $path = $request->file($field)->store($directory, $disk);

        if (! is_string($path) || $path === '') {
            abort(500, 'The uploaded file could not be stored.');
        }

        return $disk === 'public' ? Storage::disk($disk)->url($path) : $path;
    }

    private function deleteFileIfUnused(string $path, ?int $ignoreTierId = null): void
    {
        $stillInUse = ProjectPricingTier::query()
            ->where('file_path', $path)
            ->when($ignoreTierId, fn ($query) => $query->whereKeyNot($ignoreTierId))
            ->exists();

        if (! $stillInUse) {
            $this->deleteStoredFile($path, 'local');
        }
    }

    private function deleteStoredFile(string $path, string $disk): void
    {
        if (Storage::disk($disk)->exists($path) && ! Storage::disk($disk)->delete($path)) {
            abort(500, 'A stored project file could not be removed.');
        }
    }
}
