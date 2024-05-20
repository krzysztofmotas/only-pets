@extends('home.template')

@section('title')
    @yield('_title')
@endsection

@section('center-column')
    <div class="alert alert-light" role="alert">
        <h4 class="alert-heading">Wystąpił błąd (@yield('code'))</h4>
        <p>Wiadomość błędu: @yield('message').</p>
        <hr>
        <p class="mb-0">Jeżeli ten błąd będzie się powtarzać, poinformuj o tym administratora strony.</p>
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-success" role="button">Wróć do poprzedniej strony</a>
        </div>
    </div>
@endsection
