@extends('home.template')

@section('head-csrf')

    @push('head-scripts')
        <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    @endpush

@section('center-column')
    <div class="row">
        <div class="col">
            <div class="card">
                <form method="POST" action="{{ route('post.store') }}">
                    @csrf
                    <div class="card-body">
                        <textarea id="post-textarea" required name="text" class="form-control" rows="2" placeholder="Co masz na myśli?"></textarea>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-link pe-0">
                                    <i class="bi bi-images fs-5 me-2"></i>
                                </button>

                                <button id="post-emoji-button" type="button" class="btn btn-link ps-0">
                                    <i class="bi bi-emoji-smile-fill fs-5"></i>
                                </button>
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

@push('body-scripts')
    <script>
        const textarea = document.getElementById('post-textarea');
        const submitButton = document.getElementById('post-submit-button');

        textarea.addEventListener('change', () => {
            submitButton.toggleAttribute("disabled", !textarea.value.trim().length > 0);
        });

        const emojiButton = document.getElementById('post-emoji-button');
        const emojiPicker = document.createElement('emoji-picker');
        let emojiPickerVisible = false;

        emojiButton.addEventListener('click', (event) => {
            event.stopPropagation(); // Zatrzymuje propagację kliknięcia, aby nie wywoływać zamykania pickera
            const buttonRect = emojiButton.getBoundingClientRect();

            if (!emojiPickerVisible) {
                emojiPicker.style.position = 'absolute';
                emojiPicker.style.top = (buttonRect.bottom + window.scrollY) + 'px';
                emojiPicker.style.left = (buttonRect.left + window.scrollX) + 'px';
                document.body.appendChild(emojiPicker);
                emojiPickerVisible = true;
            } else {
                document.body.removeChild(emojiPicker);
                emojiPickerVisible = false;
            }
        });

        document.addEventListener('click', (event) => {
            if (!emojiPicker.contains(event.target)) {
                if (emojiPickerVisible) {
                    document.body.removeChild(emojiPicker);
                    emojiPickerVisible = false;
                }
            }
        });

        emojiPicker.addEventListener('emoji-click', (event) => {
            const emoji = event.detail.unicode;
            textarea.append(emoji);

            submitButton.disabled = false;
        });
    </script>
@endpush

@section('right-column')
@endsection
