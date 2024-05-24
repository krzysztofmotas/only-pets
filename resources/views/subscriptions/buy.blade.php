@extends('home.template')

@section('title', 'Kupno nowej subskrypcji')

@section('center-column')
    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('subscriptions.store', $user) }}">
                @csrf

                <h5 class="my-3">Informacja</h5>
                <!-- Dodaj swoje pola informacji tutaj -->

                <h5 class="my-3">Ustawienia subskrybcji</h5>
                <!-- Dodaj swoje pola ustawień subskrypcji tutaj -->

                <h5 class="my-3">Płatność</h5>

                <div class="row gy-2">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('cc-name') is-invalid @enderror" id="cc-name"
                                name="cc-name" placeholder="Imię i nazwisko na karcie"
                                value="{{ old('cc-name', Auth::user()->display_name) }}" required maxlength="255">
                            <label for="cc-name" class="form-label">Imię i nazwisko na karcie</label>
                            @error('cc-name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('cc-number') is-invalid @enderror"
                                id="cc-number" name="cc-number" placeholder="Numer karty kredytowej"
                                value="{{ old('cc-number', '4242424242424242') }}"
                                required
                                pattern="[0-9]{16}"
                                title="Numer karty kredytowej powinien składać się z 16 cyfr.">
                            <label for="cc-number" class="form-label">Numer karty kredytowej</label>
                            @error('cc-number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating mb-3">
                            <input type="text" pattern="\d{2}/\d{2}"
                                class="form-control @error('cc-expiration') is-invalid @enderror" id="cc-expiration"
                                name="cc-expiration" placeholder="Data ważności" value="{{ old('cc-expiration', '12/34') }}"
                                required
                                pattern="^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$"
                                title="Data ważności karty powinna być w formacie MM/YY lub MM/YYYY.">
                            <label for="cc-expiration" class="form-label">Data ważności</label>
                            @error('cc-expiration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-floating mb-3">
                            <input type="number" min="100" max="999"
                                class="form-control @error('cc-cvv') is-invalid @enderror" id="cc-cvv" name="cc-cvv"
                                placeholder="CVV" value="{{ old('cc-cvv', '567') }}" required>
                            <label for="cc-cvv" class="form-label">CVV</label>
                            @error('cc-cvv')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Przejdź do płatności</button>
            </form>
        </div>
    </div>
@endsection
