<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    protected $fillable = [
        'order_id',
        'gateway',
        'gateway_event_id',
        'event_type',
        'payload',
        'status',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(ProjectOrder::class, 'order_id');
    }
}
