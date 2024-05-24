@extends('home.template')

@section('title', 'Strona główna')

@push('head-scripts')
    @auth
        <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
    @endauth
@endpush

@section('center-column')
    @auth
        @include('home.new-post')
    @endauth
    @include('home.posts-feed')
@endsection

@section('right-column')
    @include('home.right-column')
@endsection
