<div class="row">
    <div class="col">
        <div class="card">
            <form id="post-create-form" method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <textarea id="post-textarea" name="text" class="form-control fs-5" rows="2"
                        placeholder="Jak się mają Twoje zwierzaki? 🐶🦴"></textarea>

                    <div id="post-carousel" class="carousel slide my-3 d-none">
                        <div id="post-carousel-attachments-container" class="carousel-inner"></div>

                        <div id="post-carousel-controls-container" class="d-none">
                            <button class="carousel-control-prev" type="button" data-bs-target="#post-carousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Poprzedni</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#post-carousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Następny</span>
                            </button>
                        </div>
                    </div>

                    <div id="post-errors-container"></div>

                    <div class="card-footer rounded border mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{-- Accept any file with an image/* MIME type.
                                (Many mobile devices also let the user take a picture with the camera when this is used.) --}}
                                <input type="file" id="post-attachments-input" accept="image/*" multiple
                                    class="d-none">

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
                </div>
            </form>
        </div>
    </div>
</div>

@push('body-scripts')
    <script>
        const fileTypes = [
            "image/jpeg",
            "image/png",
            "image/jpg",
            "image/gif",
        ];

        function validFileType(file) {
            return fileTypes.includes(file.type);
        }

        const postAttachmentsInput = document.getElementById('post-attachments-input');
        const submitButton = document.getElementById('post-submit-button');
        const newPostForm = document.getElementById('post-create-form');
        const textarea = document.getElementById('post-textarea');
        const attachmentsContainer = document.getElementById('post-carousel-attachments-container');
        const carousel = document.getElementById('post-carousel');
        const controlsContainer = document.getElementById('post-carousel-controls-container');
        const errorContainer = document.getElementById('post-errors-container');

        const attachments = [];
        let errors = [];

        function processErrors() {
            errorContainer.innerHTML = '';

            for (const error of errors) {
                const p = document.createElement('p');
                p.classList.add('text-danger', 'mb-0');
                p.textContent = error;

                errorContainer.appendChild(p);
            }

            errorContainer.classList.toggle('mt-3', errors.length > 0);
            errors = [];
        }

        newPostForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const formData = new FormData();
            formData.append('text', textarea.value);

            for (const a of attachments) {
                formData.append('attachments[]', a);
            }

            try {
                const response = await fetch('{{ route('post.store') }}', {
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    const errorData = await response.json();
                    if (errorData.errors) {
                        for (const [field, messages] of Object.entries(errorData.errors)) {
                            messages.forEach(message => {
                                errors.push(message);
                            });
                        }
                        processErrors();
                    } else {
                        console.error(response.statusText);
                    }
                }
            } catch (error) {
                console.error('Błąd podczas wysyłania żądania:', error);
            }
        });

        postAttachmentsInput.addEventListener('change', (event) => {
            const files = event.target.files;
            const max = {{ Auth::user()->getRank()->getMaxPostAttachments() }};

            for (const file of files) {
                if (attachments.length >= max) {
                    errors.push(
                        `Dodanie kolejnych załączników nie jest możliwe - osiągnięto maksymalną liczbę ${max} załączników.`
                    );
                    break;
                }

                if (!validFileType(file)) {
                    errors.push(`Nieprawidłowy typ pliku ${file.name}.`);
                    continue;
                }

                // console.log(file.size);

                if (file.size > 2097152) {
                    errors.push(`Rozmiar pliku ${file.name} przekracza limit 2MB.`);
                    continue;
                }

                attachments.push(file);

                // <div class="carousel-item active">
                const carouselItem = document.createElement('div');
                carouselItem.classList.add('carousel-item');

                switch (attachments.length) {
                    case 1:
                        carouselItem.classList.add('active');
                        break;
                    case 2:
                        controlsContainer.classList.remove('d-none');
                        break;
                }

                // <img src="" class="img-fluid rounded border mx-auto d-block" alt="...">
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = file.name;
                img.classList.add('img-fluid', 'rounded', 'border', 'mx-auto', 'd-block');
                carouselItem.append(img);

                // <div class="carousel-caption d-block bottom-0">
                const carouselCaption = document.createElement('div');
                carouselCaption.classList.add('carousel-caption', 'd-block', 'bottom-0');

                // <button type="button" class="btn btn-danger">Usuń</button>
                const button = document.createElement('button');
                button.classList.add('btn', 'btn-danger');
                button.innerHTML = 'Usuń';
                button.type = 'button';

                // </div>
                carouselCaption.append(button);

                // </div>
                carouselItem.append(carouselCaption);

                // </div>
                attachmentsContainer.append(carouselItem);

                // Odblokowanie przycisku "Wyślij".
                submitButton.disabled = false;

                if (attachments.length >= max) {
                    postAttachmentsInput.disabled = true;
                }
            }

            carousel.classList.toggle('d-none', attachments.length == 0);

            processErrors();
        });

        attachmentsContainer.addEventListener('click', (event) => {
            if (event.target.classList.contains('btn-danger')) {
                const carouselItem = event.target.closest('.carousel-item');
                const index = Array.from(attachmentsContainer.children).indexOf(carouselItem);

                if (index !== -1) {
                    const prevItem = carouselItem.previousElementSibling;
                    // console.log(prevItem);

                    if (prevItem) {
                        prevItem.classList.add('active');
                    } else {
                        const nextItem = carouselItem.nextElementSibling;

                        if (nextItem) {
                            nextItem.classList.add('active');
                        } else {
                            carousel.classList.add('d-none');
                            submitButton.disabled = true;
                        }
                    }

                    attachments.splice(index, 1);
                    carouselItem.remove();

                    if (attachments.length < 2) {
                        controlsContainer.classList.add('d-none');
                    }

                    postAttachmentsInput.disabled = false;
                }
            }
        });

        textarea.addEventListener('keyup', () => {
            submitButton.toggleAttribute('disabled', !textarea.value.trim().length > 0);
        });
    </script>
@endpush

@include('shared.emoji-picker')
