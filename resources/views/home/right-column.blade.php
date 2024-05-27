<div class="row">
    <div class="col">
        @include('home.search-input')

        @if (isset($suggestedUsers))
            <div class="mt-3">
                <h6>Sugestie użytkowników</h6>

                @foreach ($suggestedUsers as $user)
                    <div class="mb-3">
                        <x-user-card :user="$user" />
                    </div>
                @endforeach
            </div>
        @endif

        <footer>
            <div class="text-center">
                <p>&copy; {{ config('app.name' )}} &ndash; 2024</p>
            </div>
        </footer>
    </div>
</div>
