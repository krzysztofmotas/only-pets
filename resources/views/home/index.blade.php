@extends('shared.template')

@section('body-content')
    {{ Auth::check() }}
    @include('shared.footer')
@endsection
