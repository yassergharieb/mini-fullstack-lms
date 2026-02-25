@extends('layouts.guest')

@section('title', 'Verify Email | Premium LMS')

@section('content')
    <div class="glass-card animate-fade-in" style="width: 100%; max-width: 450px; padding: 2.5rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="{{ url('/') }}" class="logo" style="font-size: 2rem;">LMS.Premium</a>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Thanks for signing up! Please verify your email address by clicking on the link we just emailed to you.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div style="margin-bottom: 1rem; padding: 0.75rem; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 0.5rem; color: #22c55e; font-size: 0.85rem;">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Resend Verification Email</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline" style="cursor: pointer;">Log Out</button>
            </form>
        </div>
    </div>
@endsection
