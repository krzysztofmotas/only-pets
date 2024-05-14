@extends('shared.template')

@section('head-csrf')

@section('head-scripts')
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/translations/pl.js"></script> --}}
@endsection

@section('body-content')
    <div class="container my-3 d-flex flex-row justify-content-between" style="height: calc(100vh - 2rem);">
        <div class="d-flex flex-column p-4 bg-body-tertiary shadow rounded h-100 w-25 me-3">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4">{{ config('app.name') }}</span>
            </a>

            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">
                        <i class="bi bi-house-door-fill fs-5 me-2"></i>
                        Strona główna
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link link-body-emphasis">
                        <i class="bi bi-three-dots fs-5 me-2"></i>
                        Inne
                    </a>
                </li>
            </ul>
            <hr>

            <div class="dropdown show">
                <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32"
                        class="rounded-circle me-2">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu shadow">
                    <a class="dropdown-item" href="#">Ustawienia</a>
                    <a class="dropdown-item" href="#">Mój profil</a>
                    <div class="dropdown-divider"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Wyloguj się</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column h-100 w-50 me-3">
            <div class="card card-body mb-3 shadow border-0">
                <div class="d-flex mb-3">
                    <div class="avatar avatar-xs me-2">
                        <a href="#"> <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg"
                                alt=""> </a>
                    </div>
                    {{-- <form class="w-100">
                        <textarea class="form-control pe-4 border-0" rows="2" data-autoresize="" placeholder="Share your thoughts..."></textarea>
                    </form> --}}

                    {{-- <div id="editor" class=""></div> --}}
                </div>

                <ul class="nav nav-pills nav-stack small fw-normal">
                    <li class="nav-item">
                        <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal"
                            data-bs-target="#feedActionPhoto"> <i class="bi bi-image-fill text-success pe-2"></i>Photo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link bg-light py-1 px-2 mb-0" href="#!" data-bs-toggle="modal"
                            data-bs-target="#feedActionVideo"> <i
                                class="bi bi-camera-reels-fill text-info pe-2"></i>Video</a>
                    </li>
                    <li class="nav-item dropdown ms-lg-auto">
                        <a class="nav-link bg-light py-1 px-2 mb-0" href="#" id="feedActionShare"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="feedActionShare">
                            <li><a class="dropdown-item" href="#"> <i class="bi bi-envelope fa-fw pe-2"></i>Create a
                                    poll</a></li>
                            <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark-check fa-fw pe-2"></i>Ask
                                    a question </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#"> <i
                                        class="bi bi-pencil-square fa-fw pe-2"></i>Help</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="card shadow border-0">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-story me-2">
                                <a href="#!"> <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg"
                                        alt=""> </a>
                            </div>
                            <div>
                                <div class="nav nav-divider">
                                    <h6 class="nav-item card-title mb-0"> <a href="#!"> Lori Ferguson </a></h6>
                                    <span class="nav-item small"> 2hr</span>
                                </div>
                                <p class="mb-0 small">Web Developer at Webestica</p>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2"
                                id="cardFeedAction" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction">
                                <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Save
                                        post</a></li>
                                <li><a class="dropdown-item" href="#"> <i
                                            class="bi bi-person-x fa-fw pe-2"></i>Unfollow lori ferguson </a></li>
                                <li><a class="dropdown-item" href="#"> <i
                                            class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a></li>
                                <li><a class="dropdown-item" href="#"> <i
                                            class="bi bi-slash-circle fa-fw pe-2"></i>Block</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report
                                        post</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>I'm thrilled to share that I've completed a graduate certificate course in project management with
                        the president's honor roll.</p>
                    <img class="card-img" src="assets/images/post/3by2/01.jpg" alt="Post">
                    <ul class="nav nav-stack py-3 small">
                        <li class="nav-item">
                            <a class="nav-link active" href="#!" data-bs-container="body" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-html="true" data-bs-custom-class="tooltip-text-start"
                                data-bs-title="Frances Guerrero<br> Lori Stevens<br> Billy Vasquez<br> Judy Nguyen<br> Larry Lawson<br> Amanda Reed<br> Louis Crawford">
                                <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked (56)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments (12)</a>
                        </li>
                        <li class="nav-item dropdown ms-sm-auto">
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction">
                                <li><a class="dropdown-item" href="#"> <i
                                            class="bi bi-envelope fa-fw pe-2"></i>Send via Direct Message</a></li>
                                <li><a class="dropdown-item" href="#"> <i
                                            class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark </a></li>
                                <li><a class="dropdown-item" href="#"> <i class="bi bi-link fa-fw pe-2"></i>Copy
                                        link to post</a></li>
                                <li><a class="dropdown-item" href="#"> <i class="bi bi-share fa-fw pe-2"></i>Share
                                        post via …</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"> <i
                                            class="bi bi-pencil-square fa-fw pe-2"></i>Share to News Feed</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-flex mb-3">
                        <div class="avatar avatar-xs me-2">
                            <a href="#!"> <img class="avatar-img rounded-circle" src="assets/images/avatar/12.jpg"
                                    alt=""> </a>
                        </div>
                        <form class="nav nav-item w-100 position-relative">
                            <textarea data-autoresize="" class="form-control pe-5 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                            <button
                                class="nav-link bg-transparent px-3 position-absolute top-50 end-0 translate-middle-y border-0"
                                type="submit">
                                <i class="bi bi-send-fill"> </i>
                            </button>
                        </form>
                    </div>
                    <ul class="comment-wrap list-unstyled">
                        <li class="comment-item">
                            <div class="d-flex position-relative">
                                <div class="avatar avatar-xs">
                                    <a href="#!"><img class="avatar-img rounded-circle"
                                            src="assets/images/avatar/05.jpg" alt=""></a>
                                </div>
                                <div class="ms-2">
                                    <div class="bg-light rounded-start-top-0 p-3 rounded">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1"> <a href="#!"> Frances Guerrero </a></h6>
                                            <small class="ms-2">5hr</small>
                                        </div>
                                        <p class="small mb-0">Removed demands expense account in outward tedious do.
                                            Particular way thoroughly unaffected projection.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="card-footer border-0 pt-0">
                    <a href="#!" role="button"
                        class="btn btn-link btn-link-loader btn-sm text-secondary d-flex align-items-center"
                        data-bs-toggle="button" aria-pressed="true">
                        <div class="spinner-dots me-2">
                            <span class="spinner-dot"></span>
                            <span class="spinner-dot"></span>
                            <span class="spinner-dot"></span>
                        </div>
                        Load more comments
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column p-4 bg-body-tertiary shadow rounded h-100 w-25 me-3">

        </div>
    </div>
    @include('shared.footer')
@endsection

@section('body-scripts')
    {{-- <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                language: 'pl',
                toolbar: [
                    'undo', 'redo', '|',
                    'bold', 'italic', '|',
                    'bulletedList', 'numberedList', 'blockQuote'
                ]
            })

            .catch(error => {
                console.error(error);
            });
    </script> --}}
@endsection
