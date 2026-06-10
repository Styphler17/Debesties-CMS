<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — Debesties</title>
</head>
<body>
    <h1>Reset Password</h1>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required>
            @error('email')<span>{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')<span>{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
