<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();
        return response()->json(['status' => true, 'data' => $services]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $service = Service::create($request->all());
        return response()->json(['status' => true, 'data' => $service], 201);
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'sometimes|string|max:200',
            'description' => 'sometimes|string',
            'icon' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $service->update($request->all());
        return response()->json(['status' => true, 'data' => $service]);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['status' => true, 'message' => 'Service deleted.']);
    }
}
