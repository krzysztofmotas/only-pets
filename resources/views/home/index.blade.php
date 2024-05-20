@extends('home.template')

@section('title', 'Strona główna')

@push('head-scripts')
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
@endpush

@section('center-column')
    @include('home.new-post')
    @include('home.posts-feed')
@endsection

@section('right-column')
@endsection
