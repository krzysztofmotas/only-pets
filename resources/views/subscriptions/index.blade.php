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
                    <table class="table table-striped table-hover mt-3 border">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Użytkownik</th>
                                <th>Data rozpoczęcia</th>
                                <th>Data zakończenia</th>
                                <th>Cena</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $key => $subscription)
                                <tr>
                                    <th class="align-middle" scope="row">{{ $key + 1 }}</th>
                                    <td class="align-middle">
                                        <a href="{{ route('profile', $subscription->subscribedUser) }}" class="text-decoration-none">
                                            <x-avatar :user="$subscription->subscribedUser" size="40px" />
                                            {{ $subscription->subscribedUser->name }}
                                        </a>
                                    </td>

                                    {{-- https://stackoverflow.com/questions/35149189/use-carbon-function-in-laravel-viewblade-template --}}
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($subscription->started_at)->translatedFormat('d F Y, H:i') }}
                                    </td>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($subscription->end_at)->translatedFormat('d F Y, H:i') }}
                                    </td>
                                    <td class="align-middle">{{ $subscription->price }} zł</td>
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
