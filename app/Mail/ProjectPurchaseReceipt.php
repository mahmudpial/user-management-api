<?php

namespace App\Mail;

use App\Models\ProjectOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectPurchaseReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ProjectOrder $order,
        public string $downloadUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your project source code is ready');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.project-purchase-receipt');
    }
}
