<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @empty($pageTitle)
        <title>{{ config('app.name') }}</title>
    @else
        <title>{{ $pageTitle }} - {{ config('app.name') }}</title>
    @endempty
</head>
