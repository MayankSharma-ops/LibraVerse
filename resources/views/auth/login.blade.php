@extends('layouts.app')

@section('title', 'Login — LibraVerse Archives')

@section('content')
<div class="auth-container">
    <div class="glass-panel auth-card">
        <!-- Glow effect in the card -->
        <div class="card-glow" style="opacity: 1; --x: 50%; --y: 0%;"></div>

        <h2 style="font-family: var(--font-serif); font-size: 32px; color: var(--accent-gold); text-align: center; margin-bottom: 8px;">Access Cell</h2>
        <p style="color: var(--text-secondary); text-align: center; font-size: 14px; margin-bottom: 30px;">Enter credentials to unlock your archive cell</p>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" autocomplete="off">
            @csrf
            
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="name@domain.com">
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label for="password" class="form-label">Key Password</label>
                <input type="password" name="password" id="password" class="form-input" required placeholder="••••••••">
            </div>

            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
                <label style="display: flex; align-items: center; font-size: 13px; color: var(--text-secondary); cursor: pointer;">
                    <input type="checkbox" name="remember" class="form-checkbox">
                    Remember session
                </label>
            </div>

            <button type="submit" class="nav-btn" style="width: 100%; padding: 14px; font-size: 14px; text-align: center; display: block; border-radius: 6px;">
                Authenticate
            </button>
        </form>

        <div style="margin-top: 30px; text-align: center; font-size: 13px; color: var(--text-secondary);">
            New researcher? <a href="{{ route('register') }}" style="color: var(--accent-gold); text-decoration: none; font-weight: 600;">Initialize Cell</a>
        </div>
    </div>
</div>
@endsection
