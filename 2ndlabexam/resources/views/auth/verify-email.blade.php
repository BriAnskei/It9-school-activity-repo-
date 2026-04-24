<x-guest-layout>
    <h2>Verify your email</h2>
    <p class="subtitle">Thanks for signing up! Please verify your email address by clicking the link we just sent you. If you didn't receive it, we can send another.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">A new verification link has been sent to your email address.</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-primary">Resend Verification Email</button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-secondary">Log Out</button>
    </form>
</x-guest-layout>