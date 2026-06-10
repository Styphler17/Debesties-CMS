<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Debesties</title>
</head>
<body>
    <h1>Create Account</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<span>{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')<span>{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')<span>{{ $message }}</span>@enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
</body>
</html>
