<?php

namespace App\Events;

use App\Models\ProjectOrder;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

class OrderPaid implements ShouldDispatchAfterCommit
{
    public function __construct(
        public ProjectOrder $order,
        public string $downloadUrl,
    ) {}
}
