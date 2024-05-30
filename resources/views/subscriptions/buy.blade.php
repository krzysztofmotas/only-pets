@extends('home.template')

@section('title', 'Kupno nowej subskrypcji')

@section('center-column')
    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('subscriptions.store', $user) }}">
                @csrf

                @if (Session::has('paymentError'))
                    <h5 class="my-3">Błąd</h5>
                    <div class="alert alert-danger" role="alert">
                        Płatność nie została poprawnie przetworzona i Twoja subskrypcja dla użytkownika
                        <strong>{{ $user->display_name }}</strong>
                        nie mogła dojść do skutku. Proszę spróbować ponownie.
                        <br><strong>Szczegóły błędu:</strong> {{ Session::get('paymentError') }}
                    </div>
                @endif

                <h5 class="my-3">Informacja</h5>
                <div class="alert alert-secondary" role="alert">
                    Kupując subskrypcję dla użytkownika <strong>{{ $user->display_name }}</strong>, uzyskasz dostęp do
                    przeglądania jego postów oraz załączników.
                    <br>
                    <br>
                    80% płatności zostanie przekazane dla użytkownika, 15% zostanie przekazane na wsparcie <a
                        href="https://www.kundelek.s2.zetohosting.pl/">Schroniska
                        dla zwierząt "Kundelek"</a> w Rzeszowie, a pozostałe 5% zostanie przeznaczone na obsługę serwisu.
                    <br>
                    <br>
                    Po zakończeniu subskrypcji będziesz musiał ją ponownie wykupić. W przypadku zbliżającego się końca
                    subskrypcji otrzymasz powiadomienie.
                    <br>
                    <br>
                    <span class="text-warning">
                        Zakup subskrypcji na jeden miesiąc, będzie Cię kosztować
                        <strong>{{ env('SUBSCRIPTION_MONTH_PRICE') }} zł</strong>. Ta płatność jest jednorazowa.
                    </span>
                </div>

                <h5 class="my-3">Ustawienia subskrypcji</h5>
                <div class="row gy-2">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="subscription-length" name="length" required>
                                <option value="1">1 miesiąc</option>
                                <option value="2">2 miesiące</option>
                                <option value="6">6 miesięcy</option>
                                <option value="12">rok</option>
                            </select>
                            <label for="subscription-length" class="form-label">Długość subskrypcji</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="subscription-price" name="price"
                                value="{{ env('SUBSCRIPTION_MONTH_PRICE') }} zł" readonly>
                            <label for="subscription-price" class="form-label">Cena subskrypcji</label>
                        </div>
                    </div>

                    @push('body-scripts')
                        <script>
                            const subscriptionLength = document.getElementById('subscription-length');
                            const subscriptionPrice = document.getElementById('subscription-price');

                            subscriptionLength.addEventListener('change', function() {
                                const selectedLength = parseInt(this.value);
                                const calculatedPrice = selectedLength * {{ env('SUBSCRIPTION_MONTH_PRICE') }};
                                subscriptionPrice.value = calculatedPrice + ' zł';
                            });
                        </script>
                    @endpush
                </div>

                @can('has-active-subscription', $user->id)
                    <div class="alert alert-info" role="alert">
                        <strong>Posiadasz aktywną subskrypcję dla tego użytkownika!</strong> Oznacza to, że Twoja
                        aktualna subskrypcja zostanie przedłużona o czas, który wybierzesz.
                    </div>
                @endcan

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
                                value="{{ old('cc-number', '4242424242424242') }}" required pattern="[0-9]{16}"
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
                                name="cc-expiration" placeholder="Data ważności"
                                value="{{ old('cc-expiration', '12/34') }}" required
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
