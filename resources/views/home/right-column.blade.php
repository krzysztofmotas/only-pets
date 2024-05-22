<div class="row">
    <div class="col">
        <form class="d-flex" role="search" method="get" action="{{ route('search') }}">
            @csrf
            <div class="input-group">
                <input class="form-control" name="query" type="search" placeholder="Szukaj użytkowników"
                    aria-label="Szukaj" required>
                <button class="input-group-text btn btn-primary" type="submit">Szukaj</button>
            </div>
        </form>

        @if ($suggestedUsers)
            <div class="mt-3">
                <h6>Sugestie użytkowników</h6>

                @foreach($suggestedUsers as $user)
                    <div class="mb-3">
                        <x-user-card :user="$user" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
