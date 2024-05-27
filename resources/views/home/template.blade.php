@extends('shared.template')

@section('body-content')
    <style>
        @media (min-width: 576px) {
            #main-container {
                height: 100vh;
            }
        }
    </style>

    <div id="main-container" class="container-lg">
        <div class="row h-100">
            <div class="col-12 col-sm-2 col-xl-3 p-0 p-sm-3">
                <style>
                    /* https://getbootstrap.com/docs/5.3/layout/breakpoints/ */
                    #left-column {
                        padding: 1rem;
                    }

                    @media (max-width: 575.98px) {
                        #left-column {
                            position: fixed;
                            border-bottom: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important;
                            top: 0;
                            z-index: 1030;
                            width: 100%;
                            background-color: var(--bs-body-bg);
                        }
                    }

                    @media (min-width: 576px) {
                        #left-column {
                            height: 100%;
                            position: fixed;
                            padding-top: 0;
                        }
                    }
                </style>

                <div id="left-column">
                    @include('home.left-column')
                </div>
            </div>

            <style>
                @media (min-width: 576px) {
                    #center-column {
                        border: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color);
                        border-top: none;
                        border-bottom: none;
                    }
                }
            </style>

            @if (View::hasSection('right-column'))
                <div id="center-column" class="col-12 col-sm-9 col-lg-6 p-3">
                @else
                    <div id="center-column" class="col-12 col-sm-9 p-3">
            @endif

            <style>
                @media (max-width: 575.98px) {
                    #center-container {
                        margin-top: 21%;
                    }
                }
            </style>

            <div class="container mt-12" id="center-container">
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
