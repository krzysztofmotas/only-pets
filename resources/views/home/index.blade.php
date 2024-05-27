@extends('home.template')

@section('title', 'Strona główna')

@section('center-column')
    @auth
        @include('home.new-post')
    @endauth
    @include('home.posts-feed')
@endsection

@section('right-column')
    @include('home.right-column')
@endsection
