@extends('layouts.guest')

@section('title', 'Register | Premium LMS')

@section('content')
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 450px; padding: 2.5rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ url('/') }}" class="logo" style="font-size: 2rem;">LMS.Premium</a>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Create your account to start learning.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label for="name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autofocus autocomplete="name">
                @error('name')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autocomplete="username">
                @error('email')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Password</label>
                <input id="password" type="password" name="password" placeholder="••••••••" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autocomplete="new-password">
                @error('password')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <div style="margin-bottom: 2rem;">
                <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autocomplete="new-password">
                @error('password_confirmation')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Create Account</button>
        </form>

        <p style="text-align: center; margin-top: 2rem; color: var(--text-muted); font-size: 0.9rem;">
            Already have an account? <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600;">Sign in here</a>
        </p>
    </div>
@endsection
