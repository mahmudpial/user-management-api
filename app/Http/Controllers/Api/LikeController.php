<?php
// app/Http/Controllers/Api/LikeController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, $postId)
    {
        $request->validate([
            'type' => 'required|in:like,love,wow',
            'guest_token' => 'required_without:user_id|string',
        ]);

        $post = Post::findOrFail($postId);

        // Find existing like by user or guest token
        $query = Like::where('post_id', $post->id)
            ->where('type', $request->type);

        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('guest_token', $request->guest_token);
        }

        $existing = $query->first();

        if ($existing) {
            // Unlike — remove it
            $existing->delete();
            $message = 'Like removed.';
        } else {
            // Like — add it
            Like::create([
                'post_id' => $post->id,
                'user_id' => auth()->id() ?? null,
                'guest_token' => auth()->check() ? null : $request->guest_token,
                'type' => $request->type,
            ]);
            $message = 'Like added.';
        }

        // Return updated counts
        $counts = Like::where('post_id', $post->id)
            ->selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        return response()->json([
            'status' => true,
            'message' => $message,
            'likes' => $counts,
        ]);
    }
}