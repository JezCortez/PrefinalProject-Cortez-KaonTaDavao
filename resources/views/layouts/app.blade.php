<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kaon Ta! Davao – Cortez's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-stone-50 text-stone-800 antialiased">
    <header class="border-b bg-white">
        <div class="mx-auto max-w-6xl px-4 pt-3">
            <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight">Kaon Ta! Davao – Cortez's Food Guide</a>
        </div>
        @include('partials.nav')
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8">
        @include('partials.flash')

        @yield('content')
    </main>

    <footer class="border-t py-4 text-center text-xs text-stone-500">
        City Tourism Office · Davao City
    </footer>
</body>
</html>
