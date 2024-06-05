@extends('home.template')

@section('title')
    Edycja użytkownika {{ $user->name }}
@endsection

@section('center-column')
    <div class="d-flex flex-column">
        <form method="post" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('put')
            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="card">
                        <div class="card-header">
                            Informacje osobiste
                        </div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <input id="name" class="form-control w-auto @error('name') is-invalid @enderror"
                                    name="name" placeholder="Nazwa" value="{{ old('name', $user->name) }}"
                                    maxlength="24">
                                <label for="name" class="form-label">Nazwa</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input id="display_name"
                                    class="form-control w-auto @error('display_name') is-invalid @enderror"
                                    name="display_name" placeholder="Nazwa wyświetlana"
                                    value="{{ old('display_name', $user->display_name) }}" maxlength="40">
                                <label for="display_name" class="form-label">Nazwa wyświetlana</label>
                                @error('display_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Zmiana hasła
                        </div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <input id="new-password" type="password"
                                    class="form-control w-auto @error('new-password') is-invalid @enderror"
                                    name="new-password" autocomplete="new-password" placeholder="Nowe hasło"
                                    minlength="4">
                                <label for="new-password" class="form-label">Nowe hasło</label>
                                @error('new-password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input id="new-password-confirm" type="password" class="form-control w-auto"
                                    name="new-password_confirmation" autocomplete="new-password"
                                    placeholder="Powtórz nowe hasło" minlength="4">
                                <label for="new-password-confirm" class="form-label">Powtórz nowe hasło</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Bio i kontakt
                        </div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <textarea id="bio" class="form-control w-100 h-auto @error('bio') is-invalid @enderror" name="bio"
                                    placeholder="Bio" maxlength="1000" rows="5">{{ old('bio', $user->bio) }}</textarea>
                                <label for="bio" class="form-label">Bio</label>
                                @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input id="location" class="form-control w-auto @error('location') is-invalid @enderror"
                                    name="location" placeholder="Miejscowość" value="{{ old('location', $user->location) }}"
                                    maxlength="64">
                                <label for="location" class="form-label">Miejscowość</label>
                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input id="website_url"
                                    class="form-control w-auto @error('website_url') is-invalid @enderror"
                                    name="website_url" placeholder="Adres strony internetowej"
                                    value="{{ old('website_url', $user->website_url) }}" maxlength="100">
                                <label for="website_url" class="form-label">Adres strony internetowej</label>
                                @error('website_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-inline-flex">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Edytuj użytkownika</button>
                </div>
            </div>
        </form>

        <hr>
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="card">
                    <div class="card-header">
                        Awatar i zdjęcie w tle
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.users.update.avatar', $user) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="file" name="avatar" accept="image/*"
                                class="form-control @error('avatar') is-invalid @enderror" onchange="this.form.submit();">
                            @error('avatar')
                                <span class="invalid-feedback mt-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </form>

                        @if ($user->avatar)
                            <form method="post" action="{{ route('admin.users.delete.avatar', $user) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger mt-3">Usuń aktualny awatar</button>
                            </form>
                        @endif

                        <div class="mt-3">
                            <x-avatar :user="$user" size="160px" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Awatar i zdjęcie w tle
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('admin.users.update.background', $user) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="file" name="background" accept="image/*"
                                class="form-control @error('background') is-invalid @enderror"
                                onchange="this.form.submit();">
                            @error('background')
                                <span class="invalid-feedback mt-3" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </form>

                        @if ($user->background)
                            <form method="post" action="{{ route('admin.users.delete.background', $user) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger mt-3">Usuń aktualne zdjęcie w
                                    tle</button>
                            </form>

                            <img src="{{ asset('backgrounds/' . $user->background) }}"
                                class="img-fluid rounded border mt-3" alt="{{ $user->name }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
