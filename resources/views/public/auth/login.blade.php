<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Debesties</title>
</head>
<body>
    <h1>Sign In</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')<span>{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label>
                <input type="checkbox" name="remember" value="1">
                Remember me
            </label>
        </div>

        <button type="submit">Sign In</button>
    </form>

    <p><a href="{{ route('password.request') }}">Forgot password?</a></p>
    <p>No account? <a href="{{ route('register') }}">Create one</a></p>
</body>
</html>
