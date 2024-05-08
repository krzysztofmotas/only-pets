@extends('auth.template')

@section('title', 'Logowanie')

@section('content')
    <div class="row">
        <div class="col-12 mb-4 text-center">
            <h2>Zaloguj się</h2>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="row gy-3 overflow-hidden">
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
                        name="password" required autocomplete="current-password" placeholder="Hasło" minlength="4">

                    <label for="password" class="form-label">Hasło</label>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-12 mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    Zapamiętaj mnie
                </label>
            </div>
        </div>

        <div class="col-12">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    Zaloguj się
                </button>
            </div>
        </div>

        <div class="col-12 text-center mt-3">
            <p>Nie posiadasz konta? <a class="text-decoration-none" href="{{ route('register') }}">Zarejestruj się</a></p>
        </div>
    </form>
@endsection
