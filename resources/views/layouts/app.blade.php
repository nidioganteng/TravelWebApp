<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('MijnAmor.svg') }}" type="image/svg">
    <title>Mijn Amor Travel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-gray-800 antialiased flex flex-col min-h-screen bg-white">

    <x-front.navbar />

    <main class="grow">
        {{ $slot }}
    </main>

    <x-front.footer />

</body>

</html>