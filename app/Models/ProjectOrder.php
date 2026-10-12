<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectOrder extends Model
{
    protected $fillable = [
        'order_number',
        'project_id',
        'pricing_tier_id',
        'customer_name',
        'customer_email',
        'amount',
        'payment_gateway',
        'transaction_id',
        'currency',
        'stripe_checkout_session_id',
        'payment_status',
        'download_token',
        'download_token_encrypted',
        'download_count',
        'token_expires_at',
    ];

    protected $hidden = ['download_token', 'download_token_encrypted'];

    protected $casts = [
        'amount' => 'decimal:2',
        'download_count' => 'integer',
        'token_expires_at' => 'datetime',
        'download_token_encrypted' => 'encrypted',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(PremiumProject::class, 'project_id');
    }

    public function pricingTier(): BelongsTo
    {
        return $this->belongsTo(ProjectPricingTier::class, 'pricing_tier_id');
    }
}
