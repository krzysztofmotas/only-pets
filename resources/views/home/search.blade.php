@extends('home.template')

@section('title', 'Wyszukiwanie')

@section('center-column')
    <div class="col">
        <div class="row">
            <div class="alert alert-success" role="alert">Znaleziono {{ count($users) }} użytkowników.</div>

            @forelse($users as $user)
                <a href="{{ route('profile', $user->name) }}" class="mb-3 text-decoration-none p-0">
                    <div class="card d-flex" style="height: {{ $user->background ? '250px' : '100px' }};">
                        @if ($user->background)
                            <img class="card-img mh-100 object-fit-cover"
                                src="{{ asset('backgrounds/' . $user->background) }}" alt="{{ $user->name }}">
                        @endif

                        @if ($user->background)
                            <div class="card-img-overlay align-self-end bg-dark rounded-0 rounded-bottom-1 p-3"
                                style="--bs-bg-opacity: .5;">
                            @else
                                <div class="card-footer border-0 h-100">
                        @endif
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <x-avatar :user="$user" width="80px" height="80px" />
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-5 {{ $user->background ? 'text-white' : ''}}">{{ $user->display_name }}</h5>
                                <p class="card-text text-muted fs-6" {{ $user->background ? 'data-bs-theme=dark' : ''}}>
                                    @<span>{{ $user->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
        </div>
        </a>
    @empty
        <div class="alert alert-warning" role="alert">
            Nie znaleziono żadnych użytkowników. 🙀
        </div>
        @endforelse
    </div>
    </div>
@endsection

@section('right-column')
    @include('home.right-column')
@endsection
