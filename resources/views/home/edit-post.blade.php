@extends('home.template')

@section('title')
    @if (Auth::user()->id == $post->user->id)
        Edytowanie posta
    @else
        Edytowanie posta użytkownika {{ $post->user->display_name }}
    @endif
@endsection

@include('shared.emoji-picker')

@section('center-column')
    <div class="col">
        <div class="row">
            <div class="card">
                <form method="post" action="{{ route('post.update', compact('post')) }}">
                    @csrf
                    @method('put')

                    <div class="card-body px-1">
                        <textarea id="post-textarea" name="text" class="form-control fs-5 @error('text') is-invalid @enderror" rows="2"
                            placeholder="Jak się mają Twoje zwierzaki? 🐶🦴">{{ $post->text }}</textarea>

                        @error('text')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </form>

                <div id="edit-carousel" class="carousel slide my-3">
                    @if (!$post->attachments->isEmpty())
                        <div class="carousel-inner">
                            @foreach ($post->attachments as $index => $attachment)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset("attachments/$attachment->file_name") }}" class="img-fluid rounded border mx-auto d-block"
                                        alt="{{ $index }}">

                                    <form method="post"
                                        action="{{ route('post.attachment.delete', compact('attachment')) }}">
                                        @csrf
                                        @method('delete')
                                        <div class="carousel-caption d-block bottom-0">
                                            <button type="submit" class="btn btn-danger">Usuń</button>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        @if ($post->attachments->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#edit-carousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Poprzedni</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#edit-carousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Następny</span>
                            </button>
                        @endif
                    @endif
                </div>

                <div class="card-footer rounded border mt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button id="post-emoji-button" type="button" class="btn btn-link ps-0">
                                <i class="bi bi-emoji-smile-fill fs-5" data-bs-toggle="tooltip" data-bs-title="Emoji"></i>
                            </button>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Edytuj treść posta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('right-column')
    {{-- @include('home.right-column') --}}
@endsection
