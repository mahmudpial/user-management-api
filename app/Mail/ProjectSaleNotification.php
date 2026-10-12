<?php

namespace App\Mail;

use App\Models\ProjectOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectSaleNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ProjectOrder $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'New project sale: '.$this->order->order_number);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.project-sale-notification');
    }
}
