@extends('layouts.guest')

@section('title', 'Confirm Password | Premium LMS')

@section('content')
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 400px; padding: 2.5rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ url('/') }}" class="logo" style="font-size: 2rem;">LMS.Premium</a>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">This is a secure area. Please confirm your password before continuing.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">Password</label>
                <input id="password" type="password" name="password" placeholder="••••••••" style="width: 100%; padding: 0.75rem; background: var(--bg-dark); border: 1px solid var(--border-color); border-radius: 0.5rem; color: white; outline: none;" required autocomplete="current-password">
                @error('password')
                    <p style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Confirm</button>
        </form>
    </div>
@endsection
