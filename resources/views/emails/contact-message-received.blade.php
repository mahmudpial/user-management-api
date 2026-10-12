<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New portfolio contact</title>
</head>
<body style="margin:0; padding:32px 16px; background-color:#f3f4f6; color:#1f2937; font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden;">
        <tr>
            <td style="padding:28px 32px; background:#111827; color:#ffffff;">
                <p style="margin:0 0 8px; color:#a5b4fc; font-size:12px; font-weight:bold; letter-spacing:1.5px; text-transform:uppercase;">Portfolio contact</p>
                <h1 style="margin:0; font-size:24px; line-height:1.3;">You received a new message</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:28px 32px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="padding:0 0 18px;">
                            <p style="margin:0 0 5px; color:#6b7280; font-size:12px; font-weight:bold; text-transform:uppercase;">Sender's name</p>
                            <p style="margin:0; font-size:16px;">{{ $contact->name }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 0 18px;">
                            <p style="margin:0 0 5px; color:#6b7280; font-size:12px; font-weight:bold; text-transform:uppercase;">Sender's email</p>
                            <p style="margin:0; font-size:16px;"><a href="mailto:{{ $contact->email }}" style="color:#4f46e5; text-decoration:none;">{{ $contact->email }}</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 0 22px;">
                            <p style="margin:0 0 5px; color:#6b7280; font-size:12px; font-weight:bold; text-transform:uppercase;">Subject</p>
                            <p style="margin:0; font-size:16px;">{{ $contact->subject }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px; background:#f9fafb; border-left:4px solid #6366f1; border-radius:4px;">
                            <p style="margin:0 0 10px; color:#6b7280; font-size:12px; font-weight:bold; text-transform:uppercase;">Message</p>
                            <div style="font-size:15px; line-height:1.7; overflow-wrap:anywhere;">{!! nl2br(e($contact->message)) !!}</div>
                        </td>
                    </tr>
                </table>
                <p style="margin:24px 0 0; color:#6b7280; font-size:13px; line-height:1.5;">You can reply directly to this email to respond to {{ $contact->name }}.</p>
            </td>
        </tr>
    </table>
</body>
</html>
