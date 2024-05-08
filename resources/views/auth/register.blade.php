@extends('auth.template')

@section('title', 'Rejestracja')

@section('content')
    <div class="row">
        <div class="col-12 mb-4 text-center">
            <h2>Stwórz nowe konto</h2>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row gy-3 overflow-hidden">
            <div class="col-12">
                <div class="form-floating mb-3">
                    <input id="display_name" type="text" class="form-control @error('display_name') is-invalid @enderror"
                        name="display_name" value="{{ old('display_name') }}" required autocomplete="name" autofocus
                        placeholder="Nazwa" maxlength="40">

                    <label for="display_name" class="form-label">Nazwa</label>

                    @error('display_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Adres e-mail"
                        maxlength="255">

                    <label for="email" class="form-label">Adres e-mail</label>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password" placeholder="Hasło" minlength="4">

                    <label for="password" class="form-label">Hasło</label>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating mb-3">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password" placeholder="Powtórz hasło" minlength="4">

                    <label for="password-confirm" class="form-label">Powtórz hasło</label>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    Zarejestruj się
                </button>
            </div>
        </div>

        <div class="col-12 text-center mt-3">
            <p>Posiadasz już konto? <a class="text-decoration-none" href="{{ route('login') }}">Zaloguj się</a></p>
        </div>
    </form>
@endsection
