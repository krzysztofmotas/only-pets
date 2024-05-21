<div id="posts-container">
    <template id="post-loading-spinner-template">
        <div id="post-loading-spinner">
            <div class="row mt-3">
                <div class="col d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Ładowanie...</span>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template id="post-template">
        <div class="row mt-3">
            <div class="col">
                <div class="card">
                    <div id="post-card-header" class="card-header d-flex align-items-center">
                        <div id="post-user-avatar" class="me-3"></div>
                        <div>
                            <h5 class="mb-0">
                                <span id="post-user-display-name" class="fs-6">display name</span>
                                <span id="post-user-name" class="badge text-bg-secondary fs-6">name</span>
                            </h5>
                            <small id="post-date" class="text-muted">date</small>
                        </div>
                    </div>
                    <div id="post-card-body" class="card-body">
                        <p id="post-text" class="card-text">tekst</p>
                    </div>
                    {{-- <div class="card-footer d-flex justify-content-between"></div> --}}
                </div>
            </div>
        </div>
    </template>

    <template id="post-warning-template">
        <div class="row mt-3">
            <div class="col">
                <div class="alert alert-danger text-center" role="alert">
                    Nie ma już więcej postów. 😿
                </div>
            </div>
        </div>
    </template>

    <template id="post-carousel-indicator-template">
        <button type="button" data-bs-target="#post-carousel-id-" data-bs-slide-to="" aria-label="Załącznik "></button>
    </template>

    <template id="post-carousel-item-template">
        <div class="carousel-item">
            <img src="" class="img-thumbnail" alt="Załącznik ">
        </div>
    </template>

    <template id="post-carousel-template">
        <div id="post-carousel-id-" class="carousel slide">
            <div id="post-carousel-indicators" class="carousel-indicators"></div>
            <div id="post-carousel-items" class="carousel-inner"></div>
        </div>
    </template>

    <template id="post-carousel-controls-template">
        <div class="post-carousel-controls">
            <button class="carousel-control-prev" type="button" data-bs-target="#post-carousel-id-"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Poprzedni</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#post-carousel-id-"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Następny</span>
            </button>
        </div>
    </template>

    <template id="post-options-dropdown-template">
        <div class="ms-auto">
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" id="postMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false" data-bs-toggle="tooltip" title="Opcje">
                </button>
                <ul class="dropdown-menu" aria-labelledby="postMenuButton">
                    <li>
                        <button class="dropdown-item" type="button">
                            <i class="bi bi-pencil-square fs-5 me-2"></i>Edytuj post
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal"
                            data-bs-target="#post-options-modal-id-">
                            <i class="bi bi-trash3-fill fs-5 me-2"></i>Usuń post
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="modal fade" id="post-options-modal-id-" tabindex="-1" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalLabel">Potwierdzenie</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                    </div>
                    <div class="modal-body">
                        Czy na pewno chcesz usunąć ten post?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>

                        <form id="post-options-modal-destroy-form" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Usuń</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

@push('body-scripts')
    <script>
        let page = 1,
            loadingPosts = false,
            noMorePosts = false;

        const dateOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric'
        };

        const postsContainer = document.getElementById('posts-container');
        const spinnerTemplate = document.getElementById('post-loading-spinner-template');

        let spinner = null;

        function showLoadingSpinner() {
            postsContainer.appendChild(
                document.importNode(spinnerTemplate.content, true)
            );

            spinner = document.getElementById('post-loading-spinner');
        }

        loadMorePosts();

        window.addEventListener('scroll', () => {
            // console.log(`${window.innerHeight} + ${window.pageYOffset} >= ${document.body.scrollHeight}`);

            if (!noMorePosts && !loadingPosts &&
                (window.innerHeight + window.pageYOffset) >= document.body.scrollHeight - 100) {
                loadingPosts = true;

                page++;
                loadMorePosts();
            }
        });

        function getInitials(displayName) {
            let nameParts = displayName.split(' ');
            let initials = '';

            if (nameParts.length > 1) {
                nameParts.forEach(part => {
                    initials += part.charAt(0).toUpperCase();

                    if (initials.length >= 2) {
                        return initials;
                    }
                });
            } else {
                initials = displayName.substring(0, 2).toUpperCase();
            }
            return initials;
        }

        // views/components/avatar.blade.php
        function generateAvatarElement(user, width, height) {
            if (user.avatar) {
                return `<img class="rounded-circle border border-2" src="{{ asset('avatars/${user.avatar}') }}" alt="${user.name}" width="${width}" height="${height}">`;
            } else {
                let initials = getInitials(user.display_name);
                let fontSize = `${height / 2.5}px`;
                let backgroundColor = "var(--bs-secondary-bg)";
                let divContent = `<strong>${initials}</strong>`;

                return `<div class="rounded-circle border border-2 d-flex align-items-center justify-content-center text-primary"
                    style="
                        width: ${width}px;
                        height: ${height}px;
                        font-size: ${fontSize};
                        background-color: ${backgroundColor};
                        user-select: none;
                    ">
                    ${divContent}
                    </div>`;
            }
        }

        const postTemplate = document.getElementById('post-template');
        const postCarouselTemplate = document.getElementById('post-carousel-template');
        const postCarouselIndicatorTemplate = document.getElementById('post-carousel-indicator-template');
        const postCarouselItemTemplate = document.getElementById('post-carousel-item-template');
        const postCarouselControlsTemplate = document.getElementById('post-carousel-controls-template');
        const postOptionsDropdownTemplate = document.getElementById('post-options-dropdown-template');

        function loadMorePosts() {
            showLoadingSpinner();

            const url = `?page=${page}`;
            console.log(`loadMorePosts -> page: ${page}`);

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    spinner.remove();

                    if (data.posts.data.length === 0) {
                        const warningTemplate = document.getElementById('post-warning-template');
                        const warning = document.importNode(warningTemplate.content, true);

                        postsContainer.appendChild(warning);

                        noMorePosts = true;
                        return;
                    }

                    const isAdmin = @json(Auth::user()->isAdmin());

                    for (const post of data.posts.data) {
                        console.log(post);

                        const newPost = document.importNode(postTemplate.content, true);

                        const postUserAvatar = newPost.getElementById('post-user-avatar');
                        postUserAvatar.innerHTML = generateAvatarElement(post.user, 50, 50);

                        const postUserDisplayName = newPost.getElementById('post-user-display-name');
                        postUserDisplayName.textContent = post.user.display_name;

                        const postUserName = newPost.getElementById('post-user-name');
                        postUserName.textContent = `@${post.user.name}`;

                        const postDate = newPost.getElementById('post-date');
                        const date = new Date(post.created_at);
                        postDate.textContent = Intl.DateTimeFormat('pl-PL', dateOptions).format(date);

                        const postText = newPost.getElementById('post-text');
                        postText.textContent = post.text;

                        const isAuthor = post.user.id == @json(Auth::user()->id);
                        if (isAuthor || isAdmin) {
                            const cardHeader = newPost.getElementById('post-card-header');
                            const options = document.importNode(postOptionsDropdownTemplate.content, true);
                            const form = options.getElementById('post-options-modal-destroy-form');
                            form.action = `{{ route('post.destroy', '') }}/${post.id}`;

                            options.querySelector("[id='post-options-modal-id-']").id += post.id;
                            options.querySelector("[data-bs-target='#post-options-modal-id-']").setAttribute(
                                'data-bs-target', `#post-options-modal-id-${post.id}`);

                            cardHeader.appendChild(options);
                        }

                        if (post.attachments.length > 0) {
                            const carousel = document.importNode(postCarouselTemplate.content, true);
                            const indicators = carousel.getElementById('post-carousel-indicators');
                            const items = carousel.getElementById('post-carousel-items');
                            const cardBody = newPost.getElementById('post-card-body');

                            // <div id="post-carousel-id-" class="carousel slide">
                            const slide = carousel.getElementById('post-carousel-id-');
                            slide.id += post.id;

                            let i = 0; // iterator załączników danego posta
                            for (const attachment of post.attachments) {
                                if (post.attachments.length > 1) {
                                    const indicator = document.importNode(postCarouselIndicatorTemplate.content, true);
                                    const button = indicator.querySelector('button');

                                    button.setAttribute('data-bs-target', `#post-carousel-id-${post.id}`);
                                    button.setAttribute('data-bs-slide-to', i);
                                    button['aria-label'] += i + 1; // "Załącznik "

                                    if (i == 0) {
                                        button.classList.add('active');
                                        button['aria-current'] = 'true';
                                    }

                                    indicators.appendChild(indicator);
                                }
                                const item = document.importNode(postCarouselItemTemplate.content, true);

                                if (i == 0) {
                                    const div = item.querySelector('div');
                                    div.classList.add('active');
                                }
                                const img = item.querySelector('img');

                                img.src = `{{ asset('attachments/${attachment.file_name}') }}`;
                                img.alt += i + 1;

                                items.appendChild(item);

                                i++;
                            }

                            if (post.attachments.length > 1) {
                                const controls = document.importNode(postCarouselControlsTemplate.content, true);
                                const buttons = controls.querySelectorAll('button');

                                for (const b of buttons) {
                                    b.setAttribute('data-bs-target', `#post-carousel-id-${post.id}`);
                                }

                                slide.appendChild(controls);
                            }

                            cardBody.appendChild(carousel);
                        }

                        postsContainer.appendChild(newPost);
                    }
                })
                .catch(error => {
                    spinner.remove();
                    console.error(error);
                })
                .finally(() => {
                    loadingPosts = false;
                });
        }
    </script>
@endpush
