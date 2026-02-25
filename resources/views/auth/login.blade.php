@extends('layouts.guest')

@section('title', 'Login | Premium LMS')

@section('content')
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 400px; padding: 2.5rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ url('/') }}" class="logo" style="font-size: 2rem;">LMS.Premium</a>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Welcome back! Please login.</p>
        </div>

        @if (session('status'))
            <div style="margin-bottom: 1rem; padding: 0.75rem; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 0.5rem; color: #22c55e; font-size: 0.85rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autofocus autocomplete="username">
                @error('email')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Password</label>
                <input id="password" type="password" name="password" placeholder="••••••••" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autocomplete="current-password">
                @error('password')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.85rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: var(--text-muted);">
                    <input type="checkbox" name="remember" style="accent-color: var(--primary-color);"> Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: var(--primary-color);">Forgot password?</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Sign In</button>
        </form>

        <p style="text-align: center; margin-top: 2rem; color: var(--text-muted); font-size: 0.9rem;">
            Don't have an account? <a href="{{ route('register') }}" style="color: var(--primary-color); font-weight: 600;">Register here</a>
        </p>
    </div>
@endsection
