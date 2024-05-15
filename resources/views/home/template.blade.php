@extends('shared.template')

@section('body-content')
    <div class="container vh-100">
        <div class="row h-100">
            <div class="col-3">
                <div class="position-fixed h-100 p-3">
                    @include('home.left-column')
                </div>
            </div>

            <div class="col-6 p-3 border-start border-end">
                <div class="container">
                    @yield('center-column')
                </div>
            </div>

            <div class="col-3 d-none d-lg-block">
                <div class="position-fixed">
                    <div class="container">
                        @yield('right-column')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
