<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: sans-serif; background-color: #F8F5F0; color: #1A1410; margin: 0; padding: 24px; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #E8E5DF; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);">
        <!-- Header -->
        <div style="background-color: #1A5C2E; padding: 32px; text-align: center;">
            <h1 style="color: #E8A800; font-size: 28px; margin: 0; font-weight: 700; letter-spacing: -0.5px;">Debesties</h1>
            <p style="color: #F8F5F0; font-size: 13px; margin: 8px 0 0 0; text-transform: uppercase; letter-spacing: 1.5px;">Newsletter Broadcast</p>
        </div>
        
        <!-- Content -->
        <div style="padding: 32px;">
            <h2 style="color: #1A5C2E; font-size: 20px; font-weight: 700; margin-top: 0; margin-bottom: 20px;">{{ $subject }}</h2>
            <div style="font-size: 15px; color: #333333;">
                {!! nl2br(e($body)) !!}
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #F0EDE6; padding: 24px; text-align: center; border-top: 1px solid #E8E5DF; font-size: 12px; color: #666666;">
            <p style="margin: 0 0 8px 0;">Thank you for reading the Debesties newsletter.</p>
            <p style="margin: 0;">You are receiving this because you subscribed to updates at debesties.com.</p>
            <p style="margin: 12px 0 0 0; font-size: 11px; color: #999999;">&copy; {{ date('Y') }} Debesties CMS. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
