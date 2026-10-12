<?php

namespace Tests\Feature;

use App\Models\PremiumProject;
use App\Models\ProjectOrder;
use App\Services\StripeCheckoutGateway;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery;
use Stripe\Checkout\Session;
use Tests\TestCase;

class StripeCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_session_uses_server_price_and_returns_hosted_checkout_url(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('source/project.zip', 'zip');
        config(['services.stripe.currency' => 'usd']);

        $project = $this->createProject();
        $tier = $project->pricingTiers()->create([
            'tier_name' => 'Single License',
            'price' => '120.00',
            'discount_price' => '89.00',
            'features' => ['Source code'],
            'file_path' => 'source/project.zip',
        ]);

        $session = Session::constructFrom(['id' => 'cs_test_created', 'url' => 'https://checkout.stripe.test/session']);
        $gateway = Mockery::mock(StripeCheckoutGateway::class);
        $gateway->shouldReceive('createSession')
            ->once()
            ->withArgs(function (array $parameters, string $idempotencyKey) use ($tier): bool {
                return $parameters['line_items'][0]['price_data']['unit_amount'] === 8900
                    && $parameters['metadata']['pricing_tier_id'] === (string) $tier->id
                    && $parameters['metadata']['customer_email'] === 'buyer@example.com'
                    && $idempotencyKey !== '';
            })
            ->andReturn($session);
        $this->app->instance(StripeCheckoutGateway::class, $gateway);

        $response = $this->postJson('/api/checkout/session', [
            'pricing_tier_id' => $tier->id,
            'customer_name' => 'Project Buyer',
            'customer_email' => 'buyer@example.com',
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.checkout_url', 'https://checkout.stripe.test/session');

        $this->assertDatabaseHas('project_orders', [
            'project_id' => $project->id,
            'pricing_tier_id' => $tier->id,
            'amount' => '89.00',
            'currency' => 'usd',
            'payment_gateway' => 'stripe',
            'payment_status' => 'pending',
            'stripe_checkout_session_id' => 'cs_test_created',
            'download_token' => null,
        ]);
    }

    public function test_stripe_webhook_signature_fulfills_order_and_duplicate_event_is_idempotent(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('source/project.zip', 'zip');
        config(['services.stripe.webhook_secret' => 'whsec_test_secret']);
        $project = $this->createProject();
        $tier = $project->pricingTiers()->create([
            'tier_name' => 'Commercial License',
            'price' => '45.00',
            'features' => ['Commercial use'],
            'file_path' => 'source/project.zip',
        ]);
        $order = ProjectOrder::create([
            'order_number' => 'ORD-'.Str::upper((string) Str::ulid()),
            'project_id' => $project->id,
            'pricing_tier_id' => $tier->id,
            'customer_name' => 'Project Buyer',
            'customer_email' => 'buyer@example.com',
            'amount' => '45.00',
            'currency' => 'usd',
            'payment_gateway' => 'stripe',
            'payment_status' => 'pending',
            'stripe_checkout_session_id' => 'cs_test_paid',
        ]);
        $payload = json_encode([
            'id' => 'evt_test_paid',
            'object' => 'event',
            'api_version' => '2025-01-27.acacia',
            'created' => now()->timestamp,
            'data' => [
                'object' => [
                    'id' => 'cs_test_paid',
                    'object' => 'checkout.session',
                    'mode' => 'payment',
                    'amount_total' => 4500,
                    'currency' => 'usd',
                    'payment_status' => 'paid',
                    'payment_intent' => 'pi_test_paid',
                    'metadata' => [
                        'order_id' => (string) $order->id,
                        'order_number' => $order->order_number,
                        'project_id' => (string) $project->id,
                        'pricing_tier_id' => (string) $tier->id,
                        'customer_email' => $order->customer_email,
                    ],
                ],
            ],
            'livemode' => false,
            'pending_webhooks' => 1,
            'request' => ['id' => null, 'idempotency_key' => null],
            'type' => 'checkout.session.completed',
        ], JSON_THROW_ON_ERROR);
        $timestamp = now()->timestamp;
        $signature = hash_hmac('sha256', $timestamp.'.'.$payload, 'whsec_test_secret');

        $this->call('POST', '/api/webhooks/stripe', [], [], [], [
            'HTTP_STRIPE_SIGNATURE' => "t={$timestamp},v1={$signature}",
            'CONTENT_TYPE' => 'application/json',
        ], $payload)->assertOk();

        $fulfilledOrder = $order->fresh();
        $this->assertSame('completed', $fulfilledOrder->payment_status);
        $this->assertSame('pi_test_paid', $fulfilledOrder->transaction_id);
        $this->assertSame(64, strlen($fulfilledOrder->download_token));
        $this->assertNotSame($fulfilledOrder->download_token, $fulfilledOrder->download_token_encrypted);
        $this->assertNotNull($fulfilledOrder->token_expires_at);
        $this->assertDatabaseHas('payment_logs', [
            'gateway_event_id' => 'evt_test_paid',
            'order_id' => $order->id,
            'status' => 'processed',
        ]);

        $this->call('POST', '/api/webhooks/stripe', [], [], [], [
            'HTTP_STRIPE_SIGNATURE' => "t={$timestamp},v1={$signature}",
            'CONTENT_TYPE' => 'application/json',
        ], $payload)->assertOk();

        $this->assertDatabaseCount('payment_logs', 1);
        $this->assertSame('completed', $order->fresh()->payment_status);
    }

    public function test_stripe_webhook_rejects_invalid_signatures(): void
    {
        config(['services.stripe.webhook_secret' => 'whsec_test_secret']);

        $this->call('POST', '/api/webhooks/stripe', [], [], [], [
            'HTTP_STRIPE_SIGNATURE' => 't=1,v1=invalid',
            'CONTENT_TYPE' => 'application/json',
        ], '{"id":"evt_bad"}')
            ->assertBadRequest()
            ->assertJsonPath('success', false);
    }

    public function test_checkout_success_verification_returns_download_link_after_retrieving_session_from_stripe(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('source/project.zip', 'zip');
        $project = $this->createProject();
        $tier = $project->pricingTiers()->create([
            'tier_name' => 'Single License',
            'price' => '20.00',
            'features' => ['Source code'],
            'file_path' => 'source/project.zip',
        ]);
        $order = ProjectOrder::create([
            'order_number' => 'ORD-'.Str::upper((string) Str::ulid()),
            'project_id' => $project->id,
            'pricing_tier_id' => $tier->id,
            'customer_name' => 'Project Buyer',
            'customer_email' => 'buyer@example.com',
            'amount' => '20.00',
            'currency' => 'usd',
            'payment_gateway' => 'stripe',
            'payment_status' => 'pending',
            'stripe_checkout_session_id' => 'cs_test_verified',
        ]);
        $session = Session::constructFrom([
            'id' => 'cs_test_verified',
            'mode' => 'payment',
            'amount_total' => 2000,
            'currency' => 'usd',
            'payment_status' => 'paid',
            'payment_intent' => 'pi_test_verified',
            'metadata' => [
                'order_id' => (string) $order->id,
                'order_number' => $order->order_number,
                'project_id' => (string) $project->id,
                'pricing_tier_id' => (string) $tier->id,
                'customer_email' => $order->customer_email,
            ],
        ]);
        $gateway = Mockery::mock(StripeCheckoutGateway::class);
        $gateway->shouldReceive('retrieveSession')->once()->with('cs_test_verified')->andReturn($session);
        $this->app->instance(StripeCheckoutGateway::class, $gateway);

        $response = $this->getJson('/api/checkout/session/verify?session_id=cs_test_verified')
            ->assertOk()
            ->assertJsonPath('data.payment_status', 'completed');

        $downloadUrl = $response->json('data.download_url');
        $this->assertIsString($downloadUrl);
        $this->assertStringContainsString('/api/orders/download/', $downloadUrl);
    }

    private function createProject(): PremiumProject
    {
        return PremiumProject::create([
            'title' => 'Stripe test project',
            'summary' => 'A payment test project.',
            'full_description' => 'Details.',
            'tech_stack' => ['Laravel'],
            'is_published' => true,
        ]);
    }
}
