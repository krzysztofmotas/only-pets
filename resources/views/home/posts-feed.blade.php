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
                    <div class="card-body">
                        <div id="post-text">text example</div>

                        {{-- <div class="card-footer rounded border mt-3">
                            footer
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template id="post-warning">
        <div class="row mt-3">
            <div class="col">
                <div class="alert alert-danger text-center" role="alert">
                    Nie ma już więcej postów. 😿
                </div>
            </div>
        </div>
    </template>
</div>

@push('body-scripts')
    <script>
        let page = 0,
            loadingPosts = false,
            noMorePosts = false;

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

        const postTemplate = document.getElementById('post-template');

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
                        const warningTemplate = document.getElementById('post-warning');
                        const warning = document.importNode(warningTemplate.content, true);

                        postsContainer.appendChild(warning);

                        noMorePosts = true;
                        return;
                    }

                    for (const post of data.posts.data) {
                        const newPost = document.importNode(postTemplate.content, true);

                        const postText = newPost.getElementById('post-text');
                        postText.textContent = post.text;

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
