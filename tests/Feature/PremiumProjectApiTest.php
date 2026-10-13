<?php

namespace Tests\Feature;

use App\Models\PremiumProject;
use App\Models\ProjectOrder;
use App\Models\User;
use Database\Seeders\PremiumProjectSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class PremiumProjectApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_only_lists_published_projects_and_hides_private_file_paths(): void
    {
        $published = PremiumProject::create([
            'title' => 'Published source project',
            'summary' => 'A public summary.',
            'full_description' => 'Full project details.',
            'tech_stack' => ['Laravel', 'PostgreSQL'],
            'is_published' => true,
        ]);
        $hidden = PremiumProject::create([
            'title' => 'Unpublished source project',
            'summary' => 'A private summary.',
            'full_description' => 'Unpublished details.',
            'tech_stack' => ['Laravel'],
            'is_published' => false,
        ]);
        $published->pricingTiers()->create([
            'tier_name' => 'Single License',
            'price' => 100,
            'features' => ['Source code'],
            'file_path' => 'premium-projects/source-codes/private.zip',
        ]);

        $this->getJson('/api/premium-projects')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', $published->slug)
            ->assertJsonPath('data.0.pricing_tiers.0.formatted_price', '100.00')
            ->assertJsonMissingPath('data.0.pricing_tiers.0.file_path')
            ->assertJsonMissing(['slug' => $hidden->slug]);
    }

    public function test_order_initiation_uses_server_price_and_stores_only_a_token_hash(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('premium-projects/source-codes/source.zip', 'zip contents');
        $project = PremiumProject::create([
            'title' => 'Source project',
            'summary' => 'Summary.',
            'full_description' => 'Details.',
            'tech_stack' => ['Laravel'],
            'is_published' => true,
        ]);
        $tier = $project->pricingTiers()->create([
            'tier_name' => 'Single License',
            'price' => 120,
            'discount_price' => 90,
            'features' => ['Source code'],
            'file_path' => 'premium-projects/source-codes/source.zip',
        ]);
        $member = User::create([
            'name' => 'Alex Buyer',
            'email' => 'alex@example.com',
            'password' => 'secret-password',
        ]);
        $member->forceFill(['email_verified_at' => now()])->save();

        $response = $this->actingAs($member, 'api')->postJson('/api/orders/initiate', [
            'pricing_tier_id' => $tier->id,
            'payment_gateway' => 'manual',
        ])->assertCreated()
            ->assertJsonPath('data.order.amount', '90.00')
            ->assertJsonPath('data.order.payment_status', 'pending')
            ->assertJsonPath('data.checkout.provider_session_created', false);

        $downloadUrl = $response->json('data.download_url');
        $token = Str::afterLast($downloadUrl, '/');
        $this->assertNotSame(hash('sha256', $token), $token);
        $this->assertDatabaseHas('project_orders', [
            'pricing_tier_id' => $tier->id,
            'amount' => '90.00',
            'payment_status' => 'pending',
            'download_token' => hash('sha256', $token),
        ]);

        $this->getJson($downloadUrl)->assertForbidden();
    }

    public function test_completed_order_can_download_only_from_private_storage_and_increments_count(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('premium-projects/source-codes/package.zip', 'zip contents');
        $project = PremiumProject::create([
            'title' => 'Download project',
            'summary' => 'Summary.',
            'full_description' => 'Details.',
            'tech_stack' => ['Laravel'],
            'is_published' => true,
        ]);
        $tier = $project->pricingTiers()->create([
            'tier_name' => 'Single License',
            'price' => 100,
            'features' => ['Source code'],
            'file_path' => 'premium-projects/source-codes/package.zip',
        ]);
        $token = Str::random(64);
        $order = ProjectOrder::create([
            'order_number' => 'ORD-'.Str::upper((string) Str::ulid()),
            'project_id' => $project->id,
            'pricing_tier_id' => $tier->id,
            'customer_name' => 'Alex Buyer',
            'customer_email' => 'alex@example.com',
            'amount' => 100,
            'payment_gateway' => 'manual',
            'payment_status' => 'completed',
            'download_token' => hash('sha256', $token),
            'token_expires_at' => now()->addDay(),
        ]);

        $this->get(route('premium-projects.download', ['download_token' => $token]))
            ->assertDownload($project->slug.'-source-code.zip');

        $this->assertSame(1, $order->fresh()->download_count);
    }

    public function test_expired_download_token_is_rejected(): void
    {
        $project = PremiumProject::create([
            'title' => 'Expired download project',
            'summary' => 'Summary.',
            'full_description' => 'Details.',
            'tech_stack' => ['Laravel'],
            'is_published' => true,
        ]);
        $tier = $project->pricingTiers()->create([
            'tier_name' => 'Single License',
            'price' => 100,
            'features' => ['Source code'],
            'file_path' => 'premium-projects/source-codes/package.zip',
        ]);
        $token = Str::random(64);

        ProjectOrder::create([
            'order_number' => 'ORD-'.Str::upper((string) Str::ulid()),
            'project_id' => $project->id,
            'pricing_tier_id' => $tier->id,
            'customer_name' => 'Alex Buyer',
            'customer_email' => 'alex@example.com',
            'amount' => 100,
            'payment_gateway' => 'manual',
            'payment_status' => 'completed',
            'download_token' => hash('sha256', $token),
            'token_expires_at' => now()->subSecond(),
        ]);

        $this->getJson(route('premium-projects.download', ['download_token' => $token]))
            ->assertStatus(410);
    }

    public function test_premium_project_seeder_creates_three_projects_and_nine_tiers(): void
    {
        $this->seed(PremiumProjectSeeder::class);
        $this->seed(PremiumProjectSeeder::class);

        $this->assertDatabaseCount('premium_projects', 3);
        $this->assertDatabaseCount('project_pricing_tiers', 9);
    }
}
