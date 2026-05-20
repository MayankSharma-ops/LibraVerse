@extends('layouts.app')

@section('title', 'Register — LibraVerse Archives')

@section('content')
<div class="auth-container">
    <div class="glass-panel auth-card" style="max-width: 500px;">
        <div class="card-glow" style="opacity: 1; --x: 50%; --y: 0%;"></div>

        <h2 style="font-family: var(--font-serif); font-size: 32px; color: var(--accent-gold); text-align: center; margin-bottom: 8px;">Initialize Cell</h2>
        <p style="color: var(--text-secondary); text-align: center; font-size: 14px; margin-bottom: 30px;">Create your credentials to join the LibraVerse</p>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" autocomplete="off">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">Full Name / Identifier</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required autofocus placeholder="Mayank Sharma">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required placeholder="name@domain.com">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Key Password</label>
                <input type="password" name="password" id="password" class="form-input" required placeholder="••••••••">
            </div>

            <div class="form-group" style="margin-bottom: 32px;">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required placeholder="••••••••">
            </div>

            <button type="submit" class="nav-btn" style="width: 100%; padding: 14px; font-size: 14px; text-align: center; display: block; border-radius: 6px;">
                Establish Archive Cell
            </button>
        </form>

        <div style="margin-top: 30px; text-align: center; font-size: 13px; color: var(--text-secondary);">
            Already registered? <a href="{{ route('login') }}" style="color: var(--accent-gold); text-decoration: none; font-weight: 600;">Access Cell</a>
        </div>
    </div>
</div>
@endsection
