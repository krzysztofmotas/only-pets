<form method="post" action="{{ route('settings.other.info') }}">
    @csrf
    @method('put')
    <div class="form-floating mb-3">
        <textarea id="bio" class="form-control w-auto @error('bio') is-invalid @enderror" name="bio" placeholder="Bio"
            maxlength="1000" cols="35" rows="10">{{ old('bio', Auth::user()->bio) }}</textarea>

        <label for="bio" class="form-label">Bio</label>

        @error('bio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <input id="location" class="form-control w-auto @error('location') is-invalid @enderror" name="location"
            placeholder="Miejscowość" value="{{ old('location', Auth::user()->location) }}" maxlength="64">

        <label for="location" class="form-label">Miejscowość</label>

        @error('location')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-floating mb-3">
        <input id="website-url" class="form-control w-auto @error('website-url') is-invalid @enderror" name="website-url"
            placeholder="Adres strony internetowej" value="{{ old('website-url', Auth::user()->website_url) }}"
            maxlength="100">

        <label for="website-url" class="form-label">Adres strony internetowej</label>

        @error('website-url')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Zmień swoje dane
    </button>
</form>
