@extends('shared.template')

@section('head-csrf')

@section('body-content')
    @yield('content')
    @include('shared.footer')
@endsection
