<div class="d-flex flex-column">
    <form id="avatar-form" method="post" action="{{ route('settings.avatar') }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input id="avatar-input" type="file" name="avatar" accept="image/*"
            class="form-control mw-100 w-auto @error('avatar') is-invalid @enderror">

        @error('avatar')
            <span class="invalid-feedback mt-3" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </form>

    @push('body-scripts')
        <script>
            const avatarInput = document.getElementById('avatar-input');
            const avatarForm = document.getElementById('avatar-form');

            avatarInput.addEventListener('change', (event) => {
                const files = event.target.files;

                if (files.length) {
                    avatarForm.submit();
                }
            });
        </script>
    @endpush

    @if (Auth::user()->avatar)
        <form class="mt-3" method="post" action="{{ route('settings.delete.avatar') }}">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">Usuń aktualny awatar</button>
        </form>
    @endif

    <div class="mt-3">
        <x-avatar size="160px" />
    </div>
</div>
