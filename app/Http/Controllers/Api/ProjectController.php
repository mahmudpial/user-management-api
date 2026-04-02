<?php
// app/Http/Controllers/Api/ProjectController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Public
    public function index(Request $request)
    {
        $query = Project::orderBy('order');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('featured')) {
            $query->where('is_featured', true);
        }

        return response()->json(['status' => true, 'data' => $query->get()]);
    }

    public function show(Project $project)
    {
        return response()->json(['status' => true, 'data' => $project]);
    }

    // Admin only
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'category' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $project = Project::create($request->all());
        return response()->json(['status' => true, 'data' => $project], 201);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'sometimes|string|max:200',
            'description' => 'sometimes|string',
            'image' => 'nullable|string',
            'project_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'category' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $project->update($request->all());
        return response()->json(['status' => true, 'data' => $project]);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['status' => true, 'message' => 'Project deleted.']);
    }
}