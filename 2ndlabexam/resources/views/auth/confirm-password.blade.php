<x-guest-layout>
    <h2>Confirm password</h2>
    <p class="subtitle">This is a secure area. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" required autocomplete="current-password">
            @error('password')<p style="color:var(--danger);font-size:12px;margin-top:5px;">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="btn-primary">Confirm</button>
    </form>
</x-guest-layout>