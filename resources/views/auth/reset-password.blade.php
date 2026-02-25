@extends('layouts.guest')

@section('title', 'Reset Password | Premium LMS')

@section('content')
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 400px; padding: 2.5rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ url('/') }}" class="logo" style="font-size: 2rem;">LMS.Premium</a>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Set your new password.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autofocus autocomplete="username">
                @error('email')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">New Password</label>
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
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Reset Password</button>
        </form>
    </div>
@endsection
