{{-- forgot-password.blade.php --}}
<x-guest-layout>
    <h2>Reset password</h2>
    <p class="subtitle">Enter your email address and we'll send you a link to reset your password.</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            @error('email')<p style="color:var(--danger);font-size:12px;margin-top:5px;">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn-primary">Send Reset Link</button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('login') }}">← Back to sign in</a>
    </div>
</x-guest-layout>