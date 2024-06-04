@extends('home.template')

@section('title', 'Użytkownicy')

@section('center-column')
    <div class="row">
        <div class="col">
            <form method="get" action="{{ route('admin.users.index') }}">
                <div class="row">
                    <label for="filter" class="form-label fw-bold">Wyszukaj użytkowników</label>

                    <div class="col-auto">
                        <div class="input-group">
                            <div class="form-floating">
                                <input id="query" class="form-control" name="query" required
                                    placeholder="Nazwa lub adres e-mail" maxlength="40">
                                <label for="query" class="form-label">Nazwa lub adres e-mail</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Wyszukaj</button>
                        </div>
                    </div>
                </div>
            </form>

            @if ($users->isEmpty())
                <div class="alert alert-warning mt-3" role="alert">
                    Nie znaleziono żadnych użytkowników.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-3 border">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Użytkownik</th>
                                <th>Adres e-mail</th>
                                <th>Data rejestracji</th>
                                <th colspan="3">Data ostatniej zmiany</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <th class="align-middle" scope="row">{{ $key + 1 }}</th>
                                    <td class="align-middle">
                                        <a href="{{ route('profile', $user) }}" class="text-decoration-none">
                                            <div class="d-flex flex-row gap-2 align-items-center">
                                                <x-avatar :user="$user" size="40px" />
                                                {{ $user->name }}
                                            </div>
                                        </a>
                                    </td>
                                    <td class="align-middle">{{ $user->email }}</td>

                                    {{-- https://stackoverflow.com/questions/35149189/use-carbon-function-in-laravel-viewblade-template --}}
                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y, H:i') }}
                                    </td>

                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::parse($user->updated_at)->translatedFormat('d F Y, H:i') }}
                                    </td>

                                    <td>
                                        <a class="btn btn-primary" href="{{ route('admin.users.edit', $user) }}"
                                            role="button">Edytuj</a>
                                    </td>

                                    <td>



                                        <button class="btn btn-danger" role="button" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->name }}">Usuń</button>

                                        <div class="modal fade" id="deleteModal{{ $user->name }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="deleteModalLabel">Potwierdzenie
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Zamknij"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Czy na pewno chcesz usunąć użytkownika {{ $user->name }}?
                                                        <p class="text-danger m-0">Tej akcji nie można cofnąć.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Anuluj</button>

                                                        <form action="{{ route('admin.users.delete', $user) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger">Usuń</button>
                                                         </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
