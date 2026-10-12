<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PremiumProject extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'full_description',
        'thumbnail_url',
        'live_demo_url',
        'video_preview_url',
        'tech_stack',
        'is_featured',
        'is_published',
        'order',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (PremiumProject $project): void {
            $project->slug = static::uniqueSlug($project->slug ?: $project->title);
        });

        static::updating(function (PremiumProject $project): void {
            if ($project->isDirty('slug') && filled($project->slug)) {
                $project->slug = static::uniqueSlug($project->slug, $project->id);
            }
        });
    }

    public function pricingTiers(): HasMany
    {
        return $this->hasMany(ProjectPricingTier::class, 'project_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ProjectOrder::class, 'project_id');
    }

    private static function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'premium-project';
        $slug = $base;
        $suffix = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }
}
