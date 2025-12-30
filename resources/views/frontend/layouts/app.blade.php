<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Frontend')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Template Frontend</a>
        </div>
    </nav>

    <main class="container py-5">
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-3">
        © {{ date('Y') }} Template Frontend
    </footer>
</body>

</html>