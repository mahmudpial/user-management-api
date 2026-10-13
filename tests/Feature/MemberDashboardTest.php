<?php

namespace Tests\Feature;

use App\Models\PremiumProject;
use App\Models\ProjectOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class MemberDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_member_sees_only_their_orders_and_download_summary(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('source/member.zip', 'source');
        $member = $this->verifiedMember();
        $order = $this->createOrder($member, 'completed');
        $this->createOrder($this->verifiedMember('other@example.com'), 'completed');

        $this->actingAs($member, 'api')
            ->getJson('/api/user/dashboard')
            ->assertOk()
            ->assertJsonPath('data.summary.total_orders', 1)
            ->assertJsonPath('data.summary.completed_orders', 1)
            ->assertJsonPath('data.summary.downloads', 0)
            ->assertJsonPath('data.orders.0.id', $order->id)
            ->assertJsonPath('data.orders.0.can_download', true)
            ->assertJsonMissing(['customer_email' => 'other@example.com']);
    }

    public function test_verified_member_can_download_completed_purchase_without_expiring_token(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('source/member.zip', 'source');
        $member = $this->verifiedMember();
        $order = $this->createOrder($member, 'completed', now()->subDay());

        $this->actingAs($member, 'api')
            ->get('/api/user/orders/'.$order->id.'/download')
            ->assertDownload($order->project->slug.'-source-code.zip');

        $this->assertSame(1, $order->fresh()->download_count);
    }

    public function test_member_cannot_download_another_users_purchase(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('source/member.zip', 'source');
        $owner = $this->verifiedMember();
        $order = $this->createOrder($owner, 'completed');
        $otherMember = $this->verifiedMember('other@example.com');

        $this->actingAs($otherMember, 'api')
            ->getJson('/api/user/orders/'.$order->id.'/download')
            ->assertNotFound();
    }

    public function test_unverified_member_cannot_view_member_orders(): void
    {
        $member = User::create([
            'name' => 'Unverified Member',
            'email' => 'unverified@example.com',
            'password' => 'secret-password',
        ]);

        $this->actingAs($member, 'api')
            ->getJson('/api/user/dashboard')
            ->assertForbidden()
            ->assertJsonPath('status', false);
    }

    private function verifiedMember(string $email = 'member@example.com'): User
    {
        $user = User::create([
            'name' => 'Member',
            'email' => $email,
            'password' => 'secret-password',
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        return $user;
    }

    private function createOrder(User $member, string $status, $tokenExpiresAt = null): ProjectOrder
    {
        static $orderNumber = 0;
        $project = PremiumProject::create([
            'title' => 'Member project '.(++$orderNumber),
            'summary' => 'A member project.',
            'full_description' => 'Project details.',
            'tech_stack' => ['Laravel'],
            'is_published' => true,
        ]);
        $tier = $project->pricingTiers()->create([
            'tier_name' => 'Single License',
            'price' => 25,
            'features' => ['Source code'],
            'file_path' => 'source/member.zip',
        ]);

        return ProjectOrder::create([
            'order_number' => 'ORD-'.Str::upper((string) Str::ulid()),
            'project_id' => $project->id,
            'pricing_tier_id' => $tier->id,
            'customer_name' => $member->name,
            'customer_email' => $member->email,
            'amount' => 25,
            'payment_gateway' => 'stripe',
            'payment_status' => $status,
            'download_token' => hash('sha256', Str::random(64)),
            'token_expires_at' => $tokenExpiresAt ?? now()->addDay(),
        ]);
    }
}
