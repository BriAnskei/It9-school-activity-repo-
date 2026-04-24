<x-guest-layout>
    <h2>Welcome back</h2>
    <p class="subtitle">Sign in to your account to continue.</p>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" required>
        </div>

        @if (Route::has('password.request'))
            <div style="text-align:right; margin-bottom:8px;">
                <a href="{{ route('password.request') }}" style="font-size:13px; color:var(--brown); text-decoration:none; font-weight:500;">Forgot password?</a>
            </div>
        @endif

        <button type="submit" class="btn-primary">Sign In</button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}">Create one</a>
    </div>
</x-guest-layout>