<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = ['name', 'price', 'duration', 'features', 'is_popular', 'order'];

    protected $casts = [
        'is_popular' => 'boolean',
        'features' => 'array',
    ];
}
