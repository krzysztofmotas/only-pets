@extends('home.template')

@section('title')
    {{ $user->name }}
@endsection

@section('center-column')
    <div class="col">
        <div class="row">

        </div>
    </div>
@endsection

@section('right-column')
    @include('home.right-column')
@endsection
