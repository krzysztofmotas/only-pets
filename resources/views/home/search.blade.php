@extends('home.template')

@section('title', 'Wyszukiwanie')

@section('center-column')
    <div class="col">
        <div class="row">
            <div class="d-lg-none mb-3 px-0">
                <h6>Podaj nazwę użytkownika, którego chcesz znaleźć.</h6>

                @include('home.search-input')
            </div>

            @if (!$nav)
                @if (!$users->isEmpty())
                    <div class="alert alert-success" role="alert">Znaleziono {{ count($users) }} użytkowników.</div>
                    @foreach($users as $user)
                        <x-user-card :user="$user" />
                    @endforeach
                @else
                    <div class="alert alert-warning" role="alert">
                        Nie znaleziono żadnych użytkowników. 🙀
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

@section('right-column')
    @include('home.right-column')
@endsection
