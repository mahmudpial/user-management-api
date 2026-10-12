<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_verification_notification_accepts_sanctum_and_existing_jwt_tokens(): void
    {
        Notification::fake();
        $user = User::create([
            'name' => 'Email Buyer',
            'email' => 'buyer@example.com',
            'password' => 'secret-password',
        ]);

        $sanctumToken = $user->createToken('vue-spa')->plainTextToken;
        $this->withToken($sanctumToken)
            ->postJson('/api/email/verification-notification')
            ->assertOk()
            ->assertJsonPath('status', true);

        Notification::assertSentTo($user, VerifyEmailNotification::class);

        $jwt = JWTAuth::fromUser($user);
        $this->withToken($jwt)
            ->postJson('/api/email/verification-notification')
            ->assertOk()
            ->assertJsonPath('status', true);
    }

    public function test_verification_notification_throttles_after_six_requests_per_minute(): void
    {
        Notification::fake();
        $user = User::create([
            'name' => 'Throttle Buyer',
            'email' => 'throttle@example.com',
            'password' => 'secret-password',
        ]);
        $token = $user->createToken('vue-spa')->plainTextToken;

        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->withToken($token)->postJson('/api/email/verification-notification')->assertOk();
        }

        $this->withToken($token)
            ->postJson('/api/email/verification-notification')
            ->assertTooManyRequests();
    }

    public function test_notification_points_to_frontend_with_a_signed_backend_url(): void
    {
        config(['app.url' => 'https://api.example.test', 'app.frontend_url' => 'http://localhost:5173']);
        URL::forceRootUrl('https://api.example.test');
        $user = User::create([
            'name' => 'Verified Buyer',
            'email' => 'verify@example.com',
            'password' => 'secret-password',
        ]);

        $mail = (new VerifyEmailNotification)->toMail($user);
        $frontendUrl = parse_url($mail->actionUrl, PHP_URL_HOST).parse_url($mail->actionUrl, PHP_URL_PATH);
        parse_str((string) parse_url($mail->actionUrl, PHP_URL_QUERY), $query);

        $this->assertSame('localhost/verify-email', $frontendUrl);
        $this->assertArrayHasKey('url', $query);
        $this->assertStringContainsString('/api/email/verify/'.$user->id.'/'.sha1($user->email), $query['url']);
        $this->assertStringContainsString('signature=', $query['url']);
    }

    public function test_signed_verification_marks_user_verified_and_dispatches_event(): void
    {
        Event::fake([Verified::class]);
        $user = User::create([
            'name' => 'Verify Me',
            'email' => 'verify-me@example.com',
            'password' => 'secret-password',
        ]);
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(10),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->getJson($url)
            ->assertOk()
            ->assertJsonPath('status', true);

        $this->assertNotNull($user->fresh()->email_verified_at);
        Event::assertDispatched(Verified::class, fn (Verified $event) => $event->user->is($user));

        $this->getJson($url)
            ->assertOk()
            ->assertJsonPath('message', 'Your email address is already verified.');
    }

    public function test_invalid_or_tampered_verification_links_are_rejected(): void
    {
        $user = User::create([
            'name' => 'Invalid Verify',
            'email' => 'invalid-verify@example.com',
            'password' => 'secret-password',
        ]);
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(10),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->getJson($url.'&tampered=1')
            ->assertForbidden()
            ->assertJsonPath('status', false);
        $this->assertNull($user->fresh()->email_verified_at);
    }
}
