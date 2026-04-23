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
    <div id="page-loader"
         x-show="isLoading"
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

    <script>
        (function () {
            function showLoader() {
                var loader = document.getElementById('page-loader');
                if (loader) loader.style.display = 'flex';
            }

            // Tampilkan loader saat klik link navigasi
            document.addEventListener('click', function (e) {
                var link = e.target.closest('a[href]');
                if (!link) return;
                var href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('#') || href.startsWith('javascript:') || link.target === '_blank') return;
                showLoader();
            });

            // Tampilkan loader saat submit form (hanya jika tidak dibatalkan via confirm dialog)
            document.addEventListener('submit', function (e) {
                if (!e.defaultPrevented) {
                    showLoader();
                }
            });

            // Sembunyikan loader jika browser restore halaman dari cache (tombol back/forward)
            window.addEventListener('pageshow', function (e) {
                if (e.persisted) {
                    var loader = document.getElementById('page-loader');
                    if (loader) loader.style.display = 'none';
                }
            });
        })();
    </script>
</body>

</html>