<?php
// app/Models/Like.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'guest_token',
        'type'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}