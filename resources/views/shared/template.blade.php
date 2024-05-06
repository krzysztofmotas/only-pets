<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    @hasSection('head-csrf')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endif

    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
</head>

<body>
    @yield('body-content')
</body>

</html>
