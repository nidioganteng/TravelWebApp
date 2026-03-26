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

<body x-data="{ isLoading: true }" x-init="window.addEventListener('load', () => isLoading = false)">
    <div x-show="isLoading" 
         x-transition.opacity.duration.500ms
         style="display: none;"
         class="fixed inset-0 z-9999 flex items-center justify-center bg-white/90">
        <div class="h-14 w-14 animate-spin rounded-full border-4 border-gray-200 border-t-blue-600"></div>
    </div>
    <div>
        <div>
            {{ $slot }}
        </div>
    </div>
</body>

</html>