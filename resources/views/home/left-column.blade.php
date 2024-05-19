<div class="d-flex flex-column h-100">
    <a href="/" class="mb-3 link-body-emphasis text-decoration-none">
        <span class="fs-4">{{ config('app.name') }}</span>
    </a>

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

    <div class="dropdown show">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/krzysztofmotas.png" alt="" width="40" height="40"
                class="rounded-circle me-2 border">
            {{ Auth::user()->name }}
        </a>
        <div class="dropdown-menu shadow">
            {{-- TODO: <li> --}}
            <a class="dropdown-item" href="#">
                <i class="bi bi-person-fill fs-5 me-2"></i>
                Mój profil
            </a>

            <a class="dropdown-item" href="#">
                <i class="bi bi-gear fs-5 me-2"></i>
                Ustawienia
            </a>

            @can('admin')
                <a class="dropdown-item" href="#">
                    <i class="bi bi-sliders fs-5 me-2 text-danger"></i>
                    Panel administratora
                </a>
            @endcan

            <div class="dropdown-divider"></div>

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="bi bi-box-arrow-left fs-5 me-2"></i>
                    Wyloguj się
                </button>
            </form>
        </div>
    </div>
</div>
