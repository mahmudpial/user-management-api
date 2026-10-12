<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_submission_queues_branded_email_and_saves_message(): void
    {
        Mail::fake();
        config(['mail.contact_to' => 'pialsoftdev@gmail.com']);

        $response = $this->postJson('/api/contacts', [
            'name' => 'Jordan Example',
            'email' => 'jordan@example.com',
            'subject' => 'Project enquiry',
            'message' => "Hello,\nI would like to discuss a project.",
        ]);

        $response->assertOk()->assertExactJson([
            'success' => true,
            'message' => 'Your message has been sent successfully!',
        ]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Jordan Example',
            'email' => 'jordan@example.com',
            'subject' => 'Project enquiry',
        ]);

        Mail::assertQueued(ContactMessageReceived::class, function (ContactMessageReceived $mail): bool {
            $envelope = $mail->envelope();
            $html = $mail->render();

            return $mail->hasTo('pialsoftdev@gmail.com')
                && $envelope->replyTo[0]->address === 'jordan@example.com'
                && str_contains($html, 'Jordan Example')
                && str_contains($html, 'jordan@example.com')
                && str_contains($html, 'Project enquiry')
                && str_contains($html, 'Hello,<br')
                && ! str_contains($html, '<script>');
        });
    }

    public function test_contact_endpoint_validates_required_fields_and_email_address(): void
    {
        $this->postJson('/api/contacts', [
            'name' => 'Jordan',
            'email' => 'not-an-email',
            'subject' => '',
            'message' => '',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'subject', 'message']);
    }

    public function test_contact_endpoint_limits_submissions_to_five_per_minute_per_ip(): void
    {
        Mail::fake();
        $payload = [
            'name' => 'Jordan Example',
            'email' => 'jordan@example.com',
            'subject' => 'Project enquiry',
            'message' => 'Hello from the contact form.',
        ];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson('/api/contacts', $payload)->assertOk();
        }

        $this->postJson('/api/contacts', $payload)->assertTooManyRequests();
    }
}
