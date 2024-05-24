@props([
    'user' => Auth::user(),
    'size' => '50px',
])

{{-- generateAvatarElement, posts-feed.blade.php --}}
@if ($user->avatar)
    <img class="rounded-circle border border-2 object-fit-cover" src="{{ asset("avatars/$user->avatar") }}" alt="{{ $user->name }}"
        width="{{ $size }}" height="{{ $size }}">
@else
    <div class="rounded-circle border border-2 d-flex align-items-center justify-content-center text-primary"
        style="
            width: {{ $size }};
            height: {{ $size }};
            font-size: calc({{ $size }} / 2.5);
            background-color: var(--bs-secondary-bg);
            user-select: none;
        ">
        <strong>{{ $user->getInitials() }}</strong>
    </div>
@endif
