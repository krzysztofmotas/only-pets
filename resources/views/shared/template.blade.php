<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @hasSection('head-csrf')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif

    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script defer src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    @yield('head-scripts')
</head>

<body>
    @yield('body-content')
    @yield('body-scripts')
</body>

</html>
