<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('title_meta')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    @yield('pluginCssLinks')

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />
</head>
<body class="antialiased bg-gray-100">
    @include('partials._navigation')

    @yield('content')

    @include('partials._footer')

    @yield('pluginJsLinks')
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
