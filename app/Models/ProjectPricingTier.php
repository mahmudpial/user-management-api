<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ProjectPricingTier extends Model
{
    protected $fillable = [
        'project_id',
        'tier_name',
        'price',
        'discount_price',
        'billing_type',
        'features',
        'file_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'features' => 'array',
    ];

    protected $appends = ['formatted_price', 'file_available'];

    protected $hidden = ['file_path'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(PremiumProject::class, 'project_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ProjectOrder::class, 'pricing_tier_id');
    }

    protected function formattedPrice(): Attribute
    {
        return Attribute::get(fn (): string => number_format(
            (float) ($this->discount_price ?? $this->price),
            2,
            '.',
            ','
        ));
    }

    protected function fileAvailable(): Attribute
    {
        return Attribute::get(
            fn (): bool => filled($this->file_path) && Storage::disk('local')->exists($this->file_path)
        );
    }
}
