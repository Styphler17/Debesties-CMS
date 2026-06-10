{{-- resources/views/admin/auth/login.blade.php --}}
@extends('admin.layouts.auth')

@section('title', 'Admin Login — Debesties Studio')

@section('content')
<div class="auth-card">
    <div class="auth-logo">Debesties Studio</div>

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label class="checkbox-row">
                <input type="checkbox" name="remember_me" value="1">
                Remember me
            </label>
        </div>

        <button type="submit" class="btn">Sign In</button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('password.request') }}">Forgot your password?</a>
    </div>
</div>
@endsection
