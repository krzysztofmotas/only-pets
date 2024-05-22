@extends('home.template')

@section('title', 'Wyszukiwanie')

@section('center-column')
    <div class="col">
        <div class="row">
            @if ($users)
                <div class="alert alert-success" role="alert">Znaleziono {{ count($users) }} użytkowników.</div>
                @foreach($users as $user)
                    <x-user-card :user="$user" />
                @endforeach
            @else
                <div class="alert alert-warning" role="alert">
                    Nie znaleziono żadnych użytkowników. 🙀
                </div>
            @endif
        </div>
    </div>
@endsection

@section('right-column')
    @include('home.right-column')
@endsection
