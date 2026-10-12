<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PremiumProject;

class PremiumProjectController extends Controller
{
    public function index()
    {
        $projects = PremiumProject::query()
            ->where('is_published', true)
            ->with(['pricingTiers' => fn ($query) => $query->orderBy('id')])
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return response()->json(['status' => true, 'data' => $projects]);
    }

    public function show(string $slug)
    {
        $project = PremiumProject::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with(['pricingTiers' => fn ($query) => $query->orderBy('id')])
            ->firstOrFail();

        return response()->json(['status' => true, 'data' => $project]);
    }
}
