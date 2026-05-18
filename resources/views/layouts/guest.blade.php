<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SDJ Gadget Hub')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="guest-body">
    <div class="auth-bg" aria-hidden="true"></div>
    <main class="auth-wrapper">
        @yield('content')
    </main>
</body>
</html>
