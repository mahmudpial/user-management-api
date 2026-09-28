<?php
// app/Models/Project.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'hero_image',
        'project_url',
        'github_url',
        'category',
        'tech_stack',
        'is_featured',
        'order'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}