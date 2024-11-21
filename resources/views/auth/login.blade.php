@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Welcome Back!</h1>
        <p class="auth-subtitle">Log in to your account</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="auth-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password"
                    class="auth-input @error('password') is-invalid @enderror" required autocomplete="current-password">
                @error('password')
                <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="auth-button">Log In</button>
            </div>

            <div class="form-footer">
                <a href="{{ route('register') }}">Don't have an account? Sign up</a>
            </div>
        </form>
    </div>
</div>
@endsection
