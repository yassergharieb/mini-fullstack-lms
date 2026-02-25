@extends('layouts.guest')

@section('title', 'Forgot Password | Premium LMS')

@section('content')
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 400px; padding: 2.5rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ url('/') }}" class="logo" style="font-size: 2rem;">LMS.Premium</a>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Forgot your password? No problem. Enter your email and we'll send you a reset link.</p>
        </div>

        @if (session('status'))
            <div style="margin-bottom: 1rem; padding: 0.75rem; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 0.5rem; color: #22c55e; font-size: 0.85rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autofocus>
                @error('email')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Email Password Reset Link</button>
        </form>

        <p style="text-align: center; margin-top: 2rem; color: var(--text-muted); font-size: 0.9rem;">
            Remember your password? <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600;">Sign in here</a>
        </p>
    </div>
@endsection
