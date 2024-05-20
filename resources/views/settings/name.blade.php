<form method="post" action="{{ route('settings.name') }}">
    @csrf
    <div class="form-floating mb-3">
        <input id="name" class="form-control @error('name') is-invalid @enderror" name="name" required
            placeholder="Nazwa" value="{{ old('name', Auth::user()->name) }}" maxlength="24">

        <label for="name" class="form-label">Nazwa</label>

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Zmień nazwę
    </button>
</form>
