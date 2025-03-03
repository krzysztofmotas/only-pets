<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script defer src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    @stack('head-scripts')

    <script>
        const html = document.querySelector('html');

        const userTheme = localStorage.getItem("theme") || "light";
        document.documentElement.dataset.bsTheme = userTheme;

        function toggleTheme() {
            const currentTheme = localStorage.getItem("theme") === "dark" ? "dark" : "light";
            const newTheme = currentTheme === "dark" ? "light" : "dark";

            localStorage.setItem("theme", newTheme);
            html.dataset.bsTheme = newTheme;
        }

        const dateOptions = {
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "numeric",
            minute: "2-digit"
        };
    </script>
</head>

<body>
    <div class="vstack gap-3 position-fixed bottom-0 end-0 mb-3 me-3" style="z-index: 3000;">
        @include('shared.success-toast')
        @include('shared.error-toast')
    </div>

    @yield('body-content')
    @stack('body-scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // https://getbootstrap.com/docs/5.3/components/tooltips/
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
                tooltipTriggerEl));
        });
    </script>
</body>

</html>
