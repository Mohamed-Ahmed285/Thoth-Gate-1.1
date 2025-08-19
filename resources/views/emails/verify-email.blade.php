<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Email - Thoth Gate</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px;">
<div style="max-width: 600px; margin: auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
    <div style="text-align: center; padding: 20px;">
        <img src="{{ asset('storage/pharaoh.png') }}" alt="Thoth Gate Logo" style="width: 80px; height: auto;">
        <h1 style="margin: 10px 0; color: #333;">Thoth Gate</h1>
    </div>
    <div style="padding: 20px; color: #555;">
        <p>Hello {{ $notifiable->name }},</p>
        <p>Please click the button below to verify your email address and access Thoth Gate:</p>
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" style="background: #6b46c1; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 6px;">Verify Email</a>
        </p>
        <p>If you didn’t create an account, you can safely ignore this email.</p>
    </div>
</div>
</body>
</html>
