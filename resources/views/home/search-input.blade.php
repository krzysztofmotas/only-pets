<form class="d-flex" role="search" method="get" action="{{ route('search') }}">
    <div class="input-group">
        <input class="form-control" name="query" type="search" placeholder="Szukaj użytkowników" aria-label="Szukaj"
            required data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Podaj nazwę użytkownika, którego chcesz znaleźć">
        <button class="input-group-text btn btn-primary" type="submit">Szukaj</button>
    </div>
</form>
