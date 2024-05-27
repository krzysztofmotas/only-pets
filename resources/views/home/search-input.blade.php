<form class="d-flex" role="search" method="get" action="{{ route('search') }}">
    @csrf
    <div class="input-group">
        <input class="form-control" name="query" type="search" placeholder="Szukaj użytkowników" aria-label="Szukaj"
            required>
        <button class="input-group-text btn btn-primary" type="submit">Szukaj</button>
    </div>
</form>
