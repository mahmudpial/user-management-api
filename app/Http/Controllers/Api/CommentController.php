<?php
// app/Http/Controllers/Api/CommentController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Public — post a comment (guests or logged-in users)
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'guest_name' => 'required_without:user_id|string|max:100',
            'guest_email' => 'required_without:user_id|email',
        ]);

        $post = Post::findOrFail($postId);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id() ?? null,
            'guest_name' => auth()->check() ? null : $request->guest_name,
            'guest_email' => auth()->check() ? null : $request->guest_email,
            'body' => $request->body,
            'is_approved' => false,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Comment submitted and awaiting approval.',
            'data' => $comment
        ], 201);
    }

    // Admin — list all comments
    public function index(Request $request)
    {
        $query = Comment::with(['post:id,title', 'user:id,name'])->latest();

        if ($request->filled('approved')) {
            $query->where('is_approved', $request->approved);
        }

        return response()->json(['status' => true, 'data' => $query->paginate(20)]);
    }

    // Admin — approve comment
    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return response()->json(['status' => true, 'message' => 'Comment approved.']);
    }

    // Admin — delete comment
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['status' => true, 'message' => 'Comment deleted.']);
    }
}