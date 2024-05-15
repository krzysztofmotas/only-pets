@extends('home.template')

@section('center-column')
    <div class="row">
        <div class="col">
            <div class="card">
                <form method="POST" action="{{ route('post.store') }}">
                    @csrf
                    <div class="card-body">
                        <textarea id="post-textarea" required name="text" class="form-control mb-2" rows="2"
                            placeholder="Co masz na myśli?" style="resize: none"></textarea>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-images text-primary fs-5 me-2"></i>
                                <i class="bi bi-emoji-smile-fill text-primary fs-5"></i>
                            </div>
                            <div>
                                <button id="post-submit-button" type="submit" class="btn btn-primary"
                                    disabled>Wyślij</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">

        </div>
    </div>
@endsection

@section('body-scripts')
    <script>
        let textarea = document.getElementById('post-textarea');
        let submitButton = document.getElementById('post-submit-button')

        textarea.addEventListener('keyup', () => {
            submitButton.toggleAttribute("disabled", !textarea.value.trim().length > 0);
        });
    </script>
@endsection

@section('right-column')
@endsection
