@extends('home.template')

@section('head-csrf')

    @push('head-scripts')
        <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
    @endpush

@section('center-column')
    <div class="row">
        <div class="col">
            <div class="card">
                <form method="post" action="{{ route('post.store') }}">
                    @csrf
                    <div class="card-body">
                        <textarea id="post-textarea" required name="text" class="form-control fs-5" rows="2"
                            placeholder="Co masz na myśli?"></textarea>

                        <div id="post-errors-container"></div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{-- Accept any file with an image/* MIME type. (Many mobile devices also let the user take a picture with the camera when this is used.) --}}
                                <input type="file" id="post-attachments-input" accept="image/*" multiple class="d-none">

                                <label for="post-attachments-input" class="btn btn-link pe-0">
                                    <i class="bi bi-images fs-5 me-2" data-bs-toggle="tooltip"
                                        data-bs-title="Załączniki"></i>
                                </label>

                                <button id="post-emoji-button" type="button" class="btn btn-link ps-0">
                                    <i class="bi bi-emoji-smile-fill fs-5" data-bs-toggle="tooltip"
                                        data-bs-title="Emoji"></i>
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
        const fileTypes = [
            "image/apng",
            "image/bmp",
            "image/gif",
            "image/jpeg",
            "image/pjpeg",
            "image/png",
            "image/svg+xml",
            "image/tiff",
            "image/webp",
            "image/x-icon",
        ];

        function validFileType(file) {
            return fileTypes.includes(file.type);
        }

        const postAttachmentsInput = document.getElementById('post-attachments-input');
        const submitButton = document.getElementById('post-submit-button');

        postAttachmentsInput.addEventListener('change', (event) => {
            const files = event.target.files;
            const errors = [];

            for (const file of files) {
                console.log(file.name);

                if (!validFileType(file)) {
                    errors.push(`Nieprawidłowy typ pliku ${file.name}.`);
                    continue;
                }

                if (file.size > 7000) {
                    errors.push(`Rozmiar pliku ${file.name} przekracza limit 7MB.`);
                    continue;
                }

                submitButton.disabled = false;
            }

            const errorContainer = document.getElementById('post-errors-container');

            if (errorContainer.innerHTML !== '') {
                errorContainer.innerHTML = '';
            }

            for (const error of errors) {
                const p = document.createElement('p');
                p.classList.add('text-danger');
                p.classList.add('mb-0');
                p.textContent = error;

                errorContainer.appendChild(p);
            }

            errorContainer.classList.toggle('mt-3', errors.length > 0);
        });

        const textarea = document.getElementById('post-textarea');
        textarea.addEventListener('keyup', () => {
            submitButton.toggleAttribute('disabled', !textarea.value.trim().length > 0);
        });

        const htmlElement = document.querySelector('html');
        const theme = htmlElement.getAttribute('data-bs-theme');

        const emojiButton = document.getElementById('post-emoji-button');
        const pickerOptions = {
            onEmojiSelect: onClickEmoji,
            locale: 'pl',
            theme: theme,
            emojiButtonColors: [
                'rgba(155, 223, 88, .7)',
                'rgba(149, 211, 254, .7)',
                'rgba(247, 233, 34, .7)',
                'rgba(238, 166, 252, .7)',
                'rgba(255, 213, 143, .7)',
                'rgba(211, 209, 255, .7)',
            ],
        }
        const emojiPicker = new EmojiMart.Picker(pickerOptions)

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

        function onClickEmoji(event) {
            const emoji = event.native;
            textarea.value += emoji;

            submitButton.disabled = false;
        }
    </script>
@endpush

@section('right-column')
@endsection
