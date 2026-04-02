<?php
// app/Http/Controllers/Api/CategoryController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        return response()->json(['status' => true, 'data' => $query->get()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:blog,portfolio',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'type' => $request->type,
        ]);

        return response()->json(['status' => true, 'data' => $category], 201);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'sometimes|string|max:100',
            'type' => 'sometimes|in:blog,portfolio',
        ]);

        $category->update([
            'name' => $request->name ?? $category->name,
            'slug' => Str::slug($request->name ?? $category->name),
            'type' => $request->type ?? $category->type,
        ]);

        return response()->json(['status' => true, 'data' => $category]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['status' => true, 'message' => 'Category deleted.']);
    }
}