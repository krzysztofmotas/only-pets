<div class="d-flex flex-column">
    <form id="background-form" method="post" action="{{ route('settings.background') }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input id="background-input" type="file" name="background" accept="image/*"
            class="form-control mw-100 w-auto @error('background') is-invalid @enderror">

        @error('background')
            <span class="invalid-feedback mt-3" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </form>

    @push('body-scripts')
        <script>
            const backgroundInput = document.getElementById('background-input');
            const backgroundForm = document.getElementById('background-form');

            backgroundInput.addEventListener('change', (event) => {
                const files = event.target.files;

                if (files.length) {
                    backgroundForm.submit();
                }
            });
        </script>
    @endpush

    @if (Auth::user()->background)
        <form class="mt-3" method="post" action="{{ route('settings.delete.background') }}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Usuń aktualne zdjęcie w tle</button>
        </form>

        <img src="{{ asset('backgrounds/' . Auth::user()->background) }}" class="img-fluid rounded border mt-3"
            alt="{{ Auth::user()->name }}">
    @endif
</div>
