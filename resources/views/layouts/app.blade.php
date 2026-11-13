@props([
    'title' => null,
    'description' => null,
    'ogImage' => null,
    'robots' => 'index, follow',
])

@php
    $pageTitle = $title ?? 'Mijn Amor Travel';
    $pageDescription = $description ?? '';
    $pageOgImage = $ogImage ?? asset('img/homepage/assets/background_hero.png');
    $canonical = request()->url();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('MijnAmor.svg') }}" type="image/svg">

    <title>{{ $pageTitle }}</title>
    @if($pageDescription)
    <meta name="description" content="{{ $pageDescription }}">
    @endif
    <link rel="canonical" href="{{ $canonical }}">
    <meta name="robots" content="{{ $robots }}">

    <meta property="og:title" content="{{ $pageTitle }}">
    @if($pageDescription)
    <meta property="og:description" content="{{ $pageDescription }}">
    @endif
    <meta property="og:image" content="{{ $pageOgImage }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ __('seo.site_name') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    @if($pageDescription)
    <meta name="twitter:description" content="{{ $pageDescription }}">
    @endif
    <meta name="twitter:image" content="{{ $pageOgImage }}">

    <script>document.documentElement.classList.add('js')</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="text-gray-800 antialiased flex flex-col min-h-screen bg-white">

    <x-front.navbar />

    <main class="grow">
        {{ $slot }}
    </main>

    <x-front.footer />

</body>

</html>