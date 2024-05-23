<form method="post" action="{{ route('settings.display.name') }}">
    @csrf
    @method('put')
    <div class="form-floating mb-3">
        <input id="display-name" class="form-control @error('display-name') is-invalid @enderror" name="display-name" required
            placeholder="Nazwa wyświetlana" value="{{ old('display-name', Auth::user()->display_name) }}" maxlength="40">

        <label for="display-name" class="form-label">Nazwa wyświetlana</label>

        @error('display-name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Zmień nazwę wyświetlaną
    </button>
</form>
