<div class="d-flex flex-column h-100">
    <a href="/" class="mb-3 link-body-emphasis text-decoration-none">
        <span class="fs-4 text-center">{{ config('app.name') }}</span>
    </a>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/"
                class="nav-link link-body-emphasis {{ Route::current()->getName() === 'home' ? 'active' : '' }}">
                <i class="bi bi-house-door-fill fs-5 me-2"></i>
                Strona główna
            </a>
        </li>
        @auth
            <li>
                <a href="{{ route('profile', Auth::user()->name) }}"
                    class="nav-link link-body-emphasis {{ Route::current()->getName() === 'profile' && Auth::user()->id == $user->id ? 'active' : '' }}">
                    <i class="bi bi-person-circle fs-5 me-2"></i>
                    Mój profil
                </a>
            </li>

            <li>
                <a href=""
                    class="nav-link link-body-emphasis {{ str_contains(Route::current()->getName(), 'subscriptions') ? 'active' : '' }}">
                    <i class="bi bi-bag-heart-fill fs-5 me-2"></i>
                    Moje subskrybcje
                </a>
            </li>

            <li>
                <a href="{{ route('settings') }}"
                    class="nav-link link-body-emphasis {{ Route::current()->getName() === 'settings' ? 'active' : '' }}">
                    <i class="bi bi-gear fs-5 me-2"></i>
                    Ustawienia
                </a>
            </li>
        @endauth
    </ul>

    @guest
        <div class="vstack gap-2" style="flex: 0;">
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
        <div class="dropdown show">
            <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div class="me-2">
                    <x-avatar />
                </div>

                <div class="d-flex flex-column me-2">
                    <span class="fw-bold">{{ Auth::user()->display_name }}</span>
                    <span class="text-muted">@<span>{{ Auth::user()->name }}</span></span>
                </div>
            </a>
            <div class="dropdown-menu shadow mb-2">
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
