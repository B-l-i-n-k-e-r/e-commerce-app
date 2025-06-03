<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
     <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite + Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Optional: System dark mode auto-detect -->
    <script>
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <style>
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .dark .dropdown-menu {
            background-color: #2d3748;
            color: white;
        }
        .dark .dropdown-item:hover {
            background-color: #4a5568;
        }
    </style>
</head>
<body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="min-h-screen">
        @include('layouts.navigation')

        <main>
            @yield('content')
        </main>
    </div>

    <!-- Dark mode toggle -->
    <button onclick="document.documentElement.classList.toggle('dark')" class="fixed bottom-4 right-4 p-2 bg-gray-700 text-white rounded-full shadow">
        Toggle Dark Mode
    </button>

    <!-- Scripts: jQuery, Popper, Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap dropdown demo -->
    <div class="dropdown m-4">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
        </div>
    </div>

</body>
</html>
