<div class="d-flex flex-column navbar navbar-expand-sm h-100 pt-0 pb-0 pb-sm-3">
    <div class="d-flex align-items-center justify-content-between w-100 mb-sm-3">
        <div class="mx-0 mx-sm-auto mx-xl-3">
            <a href="/" class="mb-3 link-body-emphasis text-decoration-none fs-4">
                <span class="d-inline d-sm-none d-xl-inline">{{ config('app.name') }}</span>
                <span class="d-none d-sm-inline d-xl-none">OP</span>
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
            aria-controls="navbarContent" aria-expanded="false" aria-label="Przełącz nawigację">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbarContent">
        <div class="d-flex flex-column align-items-center align-items-sm-start h-100">
            <ul class="nav nav-pills flex-column mb-auto w-auto">
                <li class="nav-item d-flex">
                    <a href="/"
                        class="nav-link link-body-emphasis {{ Route::current()->getName() === 'home' ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill fs-5"></i>
                        <span class="d-sm-none d-xl-inline ms-2">Strona główna</span>
                    </a>
                </li>
                @auth
                    <li class="nav-item d-flex">
                        <a href="{{ route('profile', Auth::user()->name) }}"
                            class="nav-link link-body-emphasis {{ Route::current()->getName() === 'profile' && Auth::user()->id == $user->id ? 'active' : '' }}">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-sm-none d-xl-inline ms-2">Mój profil</span>
                        </a>
                    </li>

                    <li class="nav-item d-flex">
                        <a href="{{ route('subscriptions.index') }}"
                            class="nav-link link-body-emphasis {{ str_contains(Route::current()->getName(), 'subscriptions') ? 'active' : '' }}">
                            <i class="bi bi-bag-heart-fill fs-5"></i>
                            <span class="d-sm-none d-xl-inline ms-2">Moje subskrypcje</span>
                        </a>
                    </li>

                    <li class="nav-item d-flex">
                        <a href="{{ route('settings') }}"
                            class="nav-link link-body-emphasis {{ Route::current()->getName() === 'settings' ? 'active' : '' }}">
                            <i class="bi bi-gear fs-5"></i>
                            <span class="d-sm-none d-xl-inline ms-2">Ustawienia</span>
                        </a>
                    </li>
                @endauth

                <li class="nav-item d-flex d-lg-none">
                    <a href="{{ route('search', ['nav' => true]) }}"
                        class="nav-link link-body-emphasis {{ Route::current()->getName() === 'search' ? 'active' : '' }}">
                        <i class="bi bi-search fs-5"></i>
                        <span class="d-sm-none d-xl-inline ms-2">Wyszukiwanie</span>
                    </a>
                </li>
            </ul>

            @guest
                <div class="vstack gap-2 mt-2" style="flex: 0;">
                    <a class="btn btn-secondary text-left" href="{{ route('login') }}" role="button">
                        <i class="bi bi-box-arrow-in-left fs-5 me-2"></i>
                        Zaloguj się
                    </a>

                    <a class="btn btn-primary text-left" href="{{ route('register') }}" role="button">
                        <i class="bi bi-person-plus-fill fs-5 me-2"></i>
                        Zarejestruj się
                    </a>
                </div>
            @endguest

            @auth
                <style>
                    @media (min-width: 576px) and (max-width: 1199.08px) {
                        #user-dropdown .dropdown-toggle::after {
                           display: none !important;
                        }
                    }
                </style>

                <div id="user-dropdown" class="dropdown dropup show mt-3">
                    <a href="#"
                        class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="position-relative">
                            <x-avatar />

                            @php
                                $notificationsCount = Auth::user()->getNotificationsCount();
                            @endphp

                            @if ($notificationsCount)
                                <div data-bs-toggle="tooltip" data-bs-title="Posiadasz powiadomienia"
                                    class="position-absolute top-0 end-0 translate-middle bg-danger border border-2 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 20px; height: 20px; margin-top: 5px; margin-right: -10px;">
                                    <small>{{ $notificationsCount }}</small>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-column mx-2 d-sm-none d-xl-flex">
                            <span class="fw-bold">{{ Auth::user()->display_name }}</span>
                            <span class="text-muted">{{ Auth::user()->name }}</span>
                        </div>
                    </a>
                    <div class="dropdown-menu shadow mb-2">
                        <li>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#notificationsModal">
                                <i id="notifications-bell"
                                    class="bi bi-bell{{ $notificationsCount > 0 ? '-fill' : '' }} fs-5 me-2"></i>
                                Powiadomienia
                            </button>

                            {{-- Kod okienka trzeba wyciągnąć poza <div class="position-fixed h-100 p-3">,
                        ponieważ następuje konflikt i okienko pokazuje się częściowo. --}}

                            @push('body-scripts')
                                <div class="modal fade" id="notificationsModal" tabindex="-1"
                                    aria-labelledby="notificationsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="nofiticationsModalLabel">Powiadomienia</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="notificationsContent">
                                                    @if ($notificationsCount > 0)
                                                        <div class="d-flex justify-content-center">
                                                            <div class="spinner-border" role="status">
                                                                <span class="visually-hidden">Ładowanie...</span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        Nie posiadasz nowych powiadomień.
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                @if ($notificationsCount > 0)
                                                    <form action="{{ route('notifications.clear') }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Wyczyść</button>
                                                    </form>
                                                @endif

                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Zamknij</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($notificationsCount > 0)
                                    <script>
                                        const notificationsModal = document.getElementById('notificationsModal');

                                        notificationsModal.addEventListener('show.bs.modal', function() {
                                            const notificationsContent = document.getElementById('notificationsContent');

                                            fetch("{{ route('notifications') }}")
                                                .then(response => response.json())
                                                .then(data => {
                                                    console.log(data);

                                                    if (!data) {
                                                        content = 'Nie posiadasz nowych powiadomień.';
                                                    } else {
                                                        content = '<ul class="list-group">';

                                                        for (const notification of data) {
                                                            const endDate = new Date(notification.end_at);
                                                            const profileUrl = "{{ route('profile', ':userName') }}".replace(':userName',
                                                                notification.subscribed_user.name);

                                                            let message = '';
                                                            if (endDate < new Date()) {
                                                                message = 'Subskrypcja dla użytkownika ' +
                                                                    `<a href="${profileUrl}">${notification.subscribed_user.name}</a>` +
                                                                    ' zakończyła się.';
                                                            } else {
                                                                message = 'Subskrypcja dla użytkownika ' +
                                                                    `<a href="${profileUrl}">${notification.subscribed_user.name}</a>` +
                                                                    ` kończy się ${endDate.toLocaleString('pl-PL', dateOptions)}.`;
                                                            }

                                                            content += `<li class="list-group-item">${message}</li>`;
                                                        }

                                                        content += '</ul>';
                                                    }
                                                    notificationsContent.innerHTML = content;
                                                })
                                                .catch(error => {
                                                    notificationsContent.innerHTML =
                                                        'Wystąpił błąd podczas ładowania powiadomień.<br>' + error;
                                                });
                                        });
                                    </script>
                                @endif
                            @endpush
                        </li>
                        <li>
                            <button class="dropdown-item" onclick="toggleTheme()">
                                <i class="bi-moon-stars fs-5 me-2"></i>
                                Zmień kolor motywu
                            </button>
                        </li>

                        @can('admin')
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-sliders fs-5 me-2 text-danger"></i>
                                    Panel administratora
                                </a>
                            </li>
                        @endcan

                        <div class="dropdown-divider"></div>

                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <li>
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-left fs-5 me-2"></i>
                                    Wyloguj się
                                </button>
                            </li>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
