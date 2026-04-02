<?php
// app/Models/Post.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'body',
        'image',
        'status',
        'views'
    ];

    protected $casts = [
        'views' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}