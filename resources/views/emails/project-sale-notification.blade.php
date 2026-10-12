<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>New project sale</title></head>
<body style="margin:0;padding:32px 16px;background:#f3f4f6;color:#111827;font-family:Arial,Helvetica,sans-serif">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;margin:0 auto;background:#fff;border-radius:12px">
        <tr><td style="padding:24px 28px;background:#111827;color:#fff;border-radius:12px 12px 0 0">
            <h1 style="margin:0;font-size:22px">A project has been purchased</h1>
        </td></tr>
        <tr><td style="padding:24px 28px">
            <p><strong>Order:</strong> {{ $order->order_number }}</p>
            <p><strong>Project:</strong> {{ $order->project->title }}</p>
            <p><strong>License:</strong> {{ $order->pricingTier->tier_name }}</p>
            <p><strong>Customer:</strong> {{ $order->customer_name }} ({{ $order->customer_email }})</p>
            <p><strong>Amount:</strong> {{ strtoupper($order->currency) }} {{ number_format((float) $order->amount, 2) }}</p>
            <p><strong>Stripe payment:</strong> {{ $order->transaction_id }}</p>
        </td></tr>
    </table>
</body>
</html>
