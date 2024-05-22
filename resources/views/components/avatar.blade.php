@props([
    'user' => Auth::user(),
    'width' => '50px',
    'height' => '50px'
])

{{-- generateAvatarElement, posts-feed.blade.php --}}
@if ($user->avatar)
    <img class="rounded-circle border border-2 object-fit-cover" src="{{ asset("avatars/$user->avatar") }}" alt="{{ $user->name }}"
        width="{{ $width }}" height="{{ $height }}">
@else
    <div class="rounded-circle border border-2 d-flex align-items-center justify-content-center text-primary"
        style="
            width: {{ $width }};
            height: {{ $height }};
            font-size: calc({{ $height }} / 2.5);
            background-color: var(--bs-secondary-bg);
            user-select: none;
        ">
        <strong>{{ $user->getInitials() }}</strong>
    </div>
@endif
