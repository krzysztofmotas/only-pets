@extends('shared.template')

@section('body-content')
    <div class="container vh-100">
        <div class="row h-100">
            <div class="col-3">
                <div class="position-fixed h-100 p-3">
                    @include('home.left-column')
                </div>
            </div>

            @if (View::hasSection('right-column'))
                <div class="col-6 p-3 border-start border-end">
            @else
                <div class="col-9 p-3 border-start border-end">
            @endif
            <div class="container">
                @hasSection('title')
                    <h4 class="mb-3">@yield('title')</h4>
                @endif

                @yield('center-column')
            </div>
        </div>

        @hasSection('right-column')
            <div class="col-3 d-none d-lg-block">
                <div class="position-fixed p-3">
                    <div class="container">
                        @yield('right-column')
                    </div>
                </div>
            </div>
        @endif
    </div>
    </div>
@endsection
