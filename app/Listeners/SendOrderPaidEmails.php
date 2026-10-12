<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Mail\ProjectPurchaseReceipt;
use App\Mail\ProjectSaleNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendOrderPaidEmails implements ShouldQueue
{
    public function handle(OrderPaid $event): void
    {
        try {
            Mail::to($event->order->customer_email)->send(
                new ProjectPurchaseReceipt($event->order, $event->downloadUrl)
            );
            Mail::to(config('mail.sales_to'))->send(new ProjectSaleNotification($event->order));
        } catch (Throwable $exception) {
            Log::error('Could not send paid project order emails.', [
                'order_id' => $event->order->id,
                'exception' => $exception,
            ]);

            throw $exception;
        }
    }
}
