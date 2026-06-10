<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — Debesties</title>
</head>
<body>
    <h1>Forgot Password</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')<span>{{ $message }}</span>@enderror
        </div>

        <button type="submit">Send Reset Link</button>
    </form>

    <p><a href="{{ route('login') }}">Back to login</a></p>
</body>
</html>
