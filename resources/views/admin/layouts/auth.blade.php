{{-- resources/views/admin/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Debesties Studio — Login')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Outfit', sans-serif; background: #0F0C09; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .auth-card { background: #1A1410; border: 1px solid #2A221A; border-radius: 12px; padding: 40px; width: 100%; max-width: 400px; }
        .auth-logo { font-size: 22px; font-weight: 800; color: #E8A800; margin-bottom: 28px; text-align: center; letter-spacing: -0.5px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #A0917E; margin-bottom: 6px; }
        input[type=email], input[type=password], input[type=text] { width: 100%; padding: 10px 14px; background: #0F0C09; border: 1.5px solid #2A221A; border-radius: 8px; color: #F5EFE6; font-family: inherit; font-size: 14px; outline: none; }
        input:focus { border-color: #E8A800; }
        .error { font-size: 12px; color: #E05C5C; margin-top: 4px; }
        .btn { width: 100%; padding: 11px; background: #E8A800; color: #1A1410; font-family: inherit; font-size: 14px; font-weight: 700; border: none; border-radius: 8px; cursor: pointer; margin-top: 8px; }
        .btn:hover { background: #D49800; }
        .auth-footer { text-align: center; margin-top: 20px; font-size: 13px; color: #6B5E4E; }
        .auth-footer a { color: #E8A800; text-decoration: none; }
        .checkbox-row { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #A0917E; }
        .checkbox-row input { width: auto; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
