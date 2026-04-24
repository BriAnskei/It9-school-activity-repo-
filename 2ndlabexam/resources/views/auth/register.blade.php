<x-guest-layout>
    <h2>Create account</h2>
    <p class="subtitle">Fill in the details below to get started.</p>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
        </div>
        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit" class="btn-primary">Create Account</button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="{{ route('login') }}">Sign in</a>
    </div>
</x-guest-layout>