<x-guest-layout>
    <h2>Set new password</h2>
    <p class="subtitle">Choose a strong new password for your account.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input class="form-control" type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required autofocus>
            @error('email')<p style="color:var(--danger);font-size:12px;margin-top:5px;">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="password">New Password</label>
            <input class="form-control" type="password" name="password" id="password" required>
            @error('password')<p style="color:var(--danger);font-size:12px;margin-top:5px;">{{ $message }}</p>@enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm New Password</label>
            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit" class="btn-primary">Reset Password</button>
    </form>
</x-guest-layout>