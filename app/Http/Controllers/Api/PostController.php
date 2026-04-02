<?php
// app/Http/Controllers/Api/PostController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Public — published posts only
    public function index(Request $request)
    {
        $query = Post::with(['user:id,name', 'category', 'tags'])
            ->where('status', 'published');

        if ($request->filled('category')) {
            $query->whereHas(
                'category',
                fn($q) =>
                $q->where('slug', $request->category)
            );
        }
        if ($request->filled('tag')) {
            $query->whereHas(
                'tags',
                fn($q) =>
                $q->where('slug', $request->tag)
            );
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(9);
        return response()->json(['status' => true, 'data' => $posts]);
    }

    // Public — single post with view count increment
    public function show($slug)
    {
        $post = Post::with([
            'user:id,name',
            'category',
            'tags',
            'comments.user:id,name',
            'likes'
        ])->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $post->increment('views');

        return response()->json(['status' => true, 'data' => $post]);
    }

    // Admin only
    public function adminIndex()
    {
        $posts = Post::with(['category', 'tags'])
            ->latest()->paginate(15);
        return response()->json(['status' => true, 'data' => $posts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|string',
            'status' => 'nullable|in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'body' => $request->body,
            'category_id' => $request->category_id,
            'image' => $request->image,
            'status' => $request->status ?? 'draft',
        ]);

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        return response()->json([
            'status' => true,
            'data' => $post->load(['category', 'tags'])
        ], 201);
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'sometimes|string|max:200',
            'body' => 'sometimes|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|string',
            'status' => 'nullable|in:draft,published',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post->update($request->only([
            'title',
            'body',
            'category_id',
            'image',
            'status'
        ]));

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return response()->json([
            'status' => true,
            'data' => $post->load(['category', 'tags'])
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['status' => true, 'message' => 'Post deleted.']);
    }
}