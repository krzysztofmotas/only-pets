@props(['user' => Auth::user(), 'width' => '50px', 'height' => '50px'])

@if ($user->avatar)
    <img class="rounded-circle border" src="{{ asset('avatars/$user->avatar') }}" alt="{{ $user->name }}"
        width="{{ $width }}" height="{{ $height }}">
@else
    <div class="rounded-circle border d-flex align-items-center justify-content-center text-primary me-2"
        style="
            width: {{ $width }};
            height: {{ $height }};
            font-size: calc({{ $height }} / 2.5);
            background-color: var(--bs-secondary-bg);
        ">
        <strong>{{ $user->getInitials() }}</strong>
    </div>
@endif
