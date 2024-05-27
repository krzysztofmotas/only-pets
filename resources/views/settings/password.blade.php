<form method="post" action="{{ route('settings.password') }}">
    @csrf
    @method('put')
    <div class="form-floating mb-3">
        <input id="password" type="password" class="form-control w-auto @error('password') is-invalid @enderror" name="password"
            required autocomplete="current-password" placeholder="Hasło" minlength="4">

        <label for="password" class="form-label">Aktualne hasło</label>

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <input id="new-password" type="password" class="form-control w-auto @error('new-password') is-invalid @enderror"
            name="new-password" required autocomplete="new-password" placeholder="Nowe hasło" minlength="4">

        <label for="new-password" class="form-label">Nowe hasło</label>

        @error('new-password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <input id="new-password-confirm" type="password" class="form-control w-auto" name="new-password_confirmation" required
            autocomplete="new-password" placeholder="Powtórz nowe hasło" minlength="4">

        <label for="new-password-confirm" class="form-label">Powtórz nowe hasło</label>
    </div>

    <button type="submit" class="btn btn-primary">
        Zmień hasło
    </button>
</form>
