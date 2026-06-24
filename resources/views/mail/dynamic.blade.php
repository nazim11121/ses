<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $message->getSubject() }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .header { background: #343a40; color: #fff; padding: 24px 32px; font-size: 1.1rem; font-weight: bold; }
        .body { padding: 32px; color: #333; line-height: 1.7; white-space: pre-line; }
        .footer { background: #f8f9fa; padding: 16px 32px; font-size: .8rem; color: #888; text-align: center; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">{{ config('app.name') }}</div>
    <div class="body">{!! nl2br(e($bodyContent)) !!}</div>
    <div class="footer">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
</div>
</body>
</html>
