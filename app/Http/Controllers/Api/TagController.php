<?php
// app/Http/Controllers/Api/TagController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(['status' => true, 'data' => Tag::all()]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['status' => true, 'data' => $tag], 201);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['status' => true, 'message' => 'Tag deleted.']);
    }
}