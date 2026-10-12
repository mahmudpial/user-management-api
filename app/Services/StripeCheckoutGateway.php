<?php

namespace App\Services;

use Stripe\Checkout\Session;
use Stripe\StripeClient;

class StripeCheckoutGateway
{
    public function __construct(private readonly StripeClient $stripe) {}

    public function createSession(array $parameters, string $idempotencyKey): Session
    {
        return $this->stripe->checkout->sessions->create($parameters, [
            'idempotency_key' => $idempotencyKey,
        ]);
    }

    public function retrieveSession(string $sessionId): Session
    {
        return $this->stripe->checkout->sessions->retrieve($sessionId, [
            'expand' => ['payment_intent'],
        ]);
    }
}
