@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title">Join Us!</h1>
        <p class="auth-subtitle">Create a new account</p>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" type="text" name="name" class="auth-input @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="auth-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password"
                    class="auth-input @error('password') is-invalid @enderror" required autocomplete="new-password">
                @error('password')
                <span class="auth-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" class="auth-input"
                    required autocomplete="new-password">
            </div>

            <div class="form-actions">
                <button type="submit" class="auth-button">Sign Up</button>
            </div>

            <div class="form-footer">
                <a href="{{ route('login') }}">Already have an account? Log in</a>
            </div>
        </form>
    </div>
</div>
@endsection
