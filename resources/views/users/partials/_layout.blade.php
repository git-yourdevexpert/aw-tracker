<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('title_meta')

    <meta name="robots" content="noindex, nofollow" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    @yield('pluginCssLinks')

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />
    @yield('pageStyle')
</head>
<body class="antialiased bg-gray-100">
    @include('users.partials._navigation')

    @yield('content')

    @include('users.partials._footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @yield('pluginJsLinks')
    <script src="{{ mix('/js/app.js') }}"></script>
    @yield('pageScript')
</body>
</html>
