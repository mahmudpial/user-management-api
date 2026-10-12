<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    protected function verificationUrl($notifiable): string
    {
        $backendUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );

        $frontendUrl = rtrim((string) config('app.frontend_url'), '/').'/verify-email';

        return $frontendUrl.'?'.http_build_query(['url' => $backendUrl]);
    }

    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('Verify Email Address')
            ->greeting('Hello!')
            ->line('Please verify your email address to finish setting up your account.')
            ->action('Verify Email Address', $url)
            ->line('If you did not create an account, no further action is required.');
    }
}
