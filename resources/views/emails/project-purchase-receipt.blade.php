<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your project is ready</title>
</head>
<body style="margin:0;padding:32px 16px;background:#f3f4f6;color:#111827;font-family:Arial,Helvetica,sans-serif">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;margin:0 auto;background:#fff;border-radius:12px">
        <tr><td style="padding:28px 32px;background:#111827;color:#fff;border-radius:12px 12px 0 0">
            <p style="margin:0 0 8px;color:#c4b5fd;font-size:12px;text-transform:uppercase;letter-spacing:1px">Payment confirmed</p>
            <h1 style="margin:0;font-size:24px">Your source code is ready</h1>
        </td></tr>
        <tr><td style="padding:28px 32px">
            <p style="margin-top:0">Hi {{ $order->customer_name }},</p>
            <p>Thank you for your purchase. Your secure download link is available for {{ config('services.stripe.download_token_days') }} days.</p>
            <p style="margin:24px 0">
                <a href="{{ $downloadUrl }}" style="display:inline-block;padding:14px 22px;border-radius:8px;background:#6d28d9;color:#fff;text-decoration:none;font-weight:bold">Download source code</a>
            </p>
            <table role="presentation" cellspacing="0" cellpadding="0" style="font-size:14px;line-height:1.8">
                <tr><td style="padding-right:16px;color:#6b7280">Project</td><td>{{ $order->project->title }}</td></tr>
                <tr><td style="padding-right:16px;color:#6b7280">License</td><td>{{ $order->pricingTier->tier_name }}</td></tr>
                <tr><td style="padding-right:16px;color:#6b7280">Order</td><td>{{ $order->order_number }}</td></tr>
                <tr><td style="padding-right:16px;color:#6b7280">Paid</td><td>{{ strtoupper($order->currency) }} {{ number_format((float) $order->amount, 2) }}</td></tr>
            </table>
            <p style="margin-bottom:0;color:#6b7280;font-size:13px">If you need help with your purchase, reply to this email.</p>
        </td></tr>
    </table>
</body>
</html>
