<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::orderBy('order')->get();
        return response()->json(['status' => true, 'data' => $plans]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|string',
            'duration' => 'nullable|string',
            'features' => 'required|array',
            'is_popular' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $plan = PricingPlan::create($request->all());
        return response()->json(['status' => true, 'data' => $plan], 201);
    }

    public function update(Request $request, PricingPlan $plan)
    {
        $request->validate([
            'name' => 'sometimes|string|max:100',
            'price' => 'sometimes|string',
            'duration' => 'nullable|string',
            'features' => 'sometimes|array',
            'is_popular' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $plan->update($request->all());
        return response()->json(['status' => true, 'data' => $plan]);
    }

    public function destroy(PricingPlan $plan)
    {
        $plan->delete();
        return response()->json(['status' => true, 'message' => 'Pricing plan deleted.']);
    }
}
