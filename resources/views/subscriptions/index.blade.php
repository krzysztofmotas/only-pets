@extends('home.template')

@section('title', 'Moje subskrypcje')

@section('center-column')
    <div class="row">
        <div class="col">
            <form method="get" action="{{ route('subscriptions.index') }}">
                <label for="filter" class="form-label fw-bold">Filtruj subskrypcje</label>

                <select name="filter" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Wszystkie</option>
                    <option value="active" {{ $filter === 'active' ? 'selected' : '' }}>Aktywne</option>
                    <option value="inactive" {{ $filter === 'inactive' ? 'selected' : '' }}>Nieaktywne</option>
                </select>
            </form>

            @if ($subscriptions->isEmpty())
                <div class="alert alert-warning mt-3" role="alert">
                    Brak subskrypcji do wyświetlenia.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mt-3 border">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Użytkownik</th>
                                <th>Data rozpoczęcia</th>
                                <th>Data zakończenia</th>
                                <th>Cena</th>
                                <th>Autoodnawianie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $key => $subscription)
                                <tr class="{{ !$subscription->isExpired() ? 'table-active' : ''}}">
                                    <th class="align-middle" scope="row">{{ $key + 1 }}</th>
                                    <td class="align-middle">
                                        <a href="{{ route('profile', $subscription->subscribedUser) }}"
                                            class="text-decoration-none">
                                            <div class="d-flex flex-row gap-2 align-items-center">
                                                <x-avatar :user="$subscription->subscribedUser" size="40px" />
                                                {{ $subscription->subscribedUser->name }}
                                            </div>
                                        </a>
                                    </td>

                                    {{-- https://stackoverflow.com/questions/35149189/use-carbon-function-in-laravel-viewblade-template --}}
                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::parse($subscription->started_at)->translatedFormat('d F Y, H:i') }}
                                    </td>
                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::parse($subscription->end_at)->translatedFormat('d F Y, H:i') }}
                                    </td>
                                    <td class="align-middle">{{ $subscription->price }} zł</td>
                                    <td class="align-middle">
                                        @if ($subscription->subscriber->getRank()->canAutoRenewSubscription())
                                            <div class="form-check form-switch">
                                                @if ($subscription->isExpired())
                                                    <input class="form-check-input" type="checkbox" role="switch" disabled>
                                                @else
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="autoRenewSwitch-{{ $subscription->id }}"
                                                        {{ $subscription->auto_renew ? 'checked' : '' }}>
                                                @endif
                                            </div>
                                        @else
                                            <div class="form-check form-switch d-inline-block" tabindex="0"
                                                data-bs-toggle="tooltip"
                                                title="Twoja ranga nie pozwala na autoodnawianie subskrypcji!">
                                                <input class="form-check-input" type="checkbox" role="switch" disabled>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('body-scripts')
    <script>
        const autoRenewSwitches = document.querySelectorAll('[id^="autoRenewSwitch-"]');

        autoRenewSwitches.forEach(autoRenewSwitch => {
            autoRenewSwitch.addEventListener('change', function() {
                const subscriptionId = this.id.split('-').pop();
                const isChecked = this.checked ? true : false;

                fetch("{{ route('subscriptions.switch.auto.renew') }}", {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            subscription_id: subscriptionId,
                            auto_renew: isChecked
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.errors) {
                            const errorMessages = Object.values(data.errors).flat().join('\n');
                            console.error(errorMessages);
                        }
                    })
                    .catch(error => {
                        console.error(error.message);
                    });
            });
        });
    </script>
@endpush
