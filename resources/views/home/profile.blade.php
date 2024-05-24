@extends('home.template')

@section('title')
    {{ $user->name }}
@endsection

@section('center-column')
    <div class="col">
        <div class="row">
            <div class="card p-0">
                <div class="rounded-top text-white d-flex flex-row"
                    style="height: 200px; {{ $user->background ? 'background-image: url(' . asset('backgrounds/' . $user->background) . '); background-size: cover; background-position: center;' : '' }}">

                    <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                        <div class="mt-4 mb-2" style="z-index: 1;">
                            <x-avatar :user="$user" width="150px" height="150px" />
                        </div>

                        @if (Auth::user()->id == $user->id)
                            <a href="{{ route('settings') }}" class="btn btn-primary" role="button" style="z-index: 1;">
                                <i class="bi bi-pencil-square fs-5 me-2"></i>
                                Edytuj profil
                            </a>
                        @else
                        @endif
                    </div>
                    <div class="ms-3" style="margin-top: 130px;">
                        <h5 class="mb-0">{{ $user->display_name }}</h5>
                        <p><span class="text-muted">@<span>{{ $user->name }}</span></span></p>
                    </div>
                </div>
                <div class="p-4 pb-3 bg-body-tertiary rounded-bottom">
                    <div class="d-flex justify-content-end text-center py-1 text-body">
                        <div>
                            <p class="mb-1 h5">{{ $attachmentsCount }}</p>
                            <p class="small text-muted mb-0">Załączników</p>
                        </div>
                        <div class="px-3">
                            <p class="mb-1 h5">{{ $postsCount }}</p>
                            <p class="small text-muted mb-0">Postów</p>
                        </div>
                        <div>
                            <p class="mb-1 h5">{{ number_format($averagePostsPerDay, 2) }}</p>
                            <p class="small text-muted mb-0">Postów na dzień</p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <hr>
                        <h5>O mnie</h5>

                        @if ($user->bio)
                            <p>{{ $user->bio }}</p>
                        @endif

                        <p>
                            <span class="badge text-bg-primary me-1 fs-6" data-bs-toggle="tooltip" data-bs-title="Data rejestracji"><i class="bi bi-calendar-check-fill"></i></span>
                            {{ $user->created_at->format('d-m-Y, H:i:s') }}
                        </p>

                        @if ($user->location)
                            <p>
                                <span class="badge text-bg-primary me-1 fs-6" data-bs-toggle="tooltip" data-bs-title="Miejscowość"><i class="bi bi-house-door-fill"></i></span>
                                {{ $user->location }}
                            </p>
                        @endif

                        @if ($user->website_url)
                        <p>
                            <span class="badge text-bg-primary me-1 fs-6" data-bs-toggle="tooltip" data-bs-title="Strona internetowa"><i class="bi bi-globe-americas"></i></span>
                            <a href="{{ $user->website_url }}">{{ $user->website_url }}</a>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('right-column')
    @include('home.right-column')
@endsection
