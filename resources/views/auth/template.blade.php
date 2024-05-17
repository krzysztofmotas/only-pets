@extends('shared.template')

@section('body-content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-3 p-md-4 p-xl-4">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
