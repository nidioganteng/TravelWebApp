<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('MijnAmor.svg') }}" type="image/svg">
    <title>Mijn Amor Travel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative min-h-screen w-full overflow-hidden flex items-center justify-center bg-gray-900"
      x-data="{ 
          isLoading: true,
          activeSlide: 0, 
          slides: [
              '{{ asset('img/admin/login/assets/view_one.svg') }}',
              '{{ asset('img/admin/login/assets/view_two.svg') }}',
              '{{ asset('img/admin/login/assets/view_three.svg') }}'
          ] 
      }"
      x-init="
          window.addEventListener('load', () => isLoading = false);
          setInterval(() => { activeSlide = (activeSlide + 1) % slides.length }, 5000);
      ">

    {{-- Elemen Loading Overlay (Versi Dark Mode) --}}
    <div x-show="isLoading" 
         x-transition.opacity.duration.500ms
         style="display: none;"
         class="fixed inset-0 z-9999 flex items-center justify-center bg-gray-900/90 backdrop-blur-sm">
        <div class="h-14 w-14 animate-spin rounded-full border-4 border-white/20 border-t-[#0099FF]"></div>
    </div>  
    
    @php
        $languages = [
            ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
            ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
            ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png'],
            ['code' => 'de', 'name' => 'DE', 'flag' => 'https://flagcdn.com/w40/de.png'],
            ['code' => 'pt', 'name' => 'PT', 'flag' => 'https://flagcdn.com/w40/pt.png']
        ];

        $currentLocale = app()->getLocale();
        $currentLang = collect($languages)->firstWhere('code', $currentLocale) ?: $languages[0];
    @endphp

    {{-- 2. POSISI POJOK KANAN ATAS (LANGUAGE SWITCHER) --}}
    <div class="absolute top-6 right-6 z-50">
        <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
            <button
                @click="langOpen = !langOpen"
                class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition bg-black/30 backdrop-blur-sm px-3 py-2 rounded-full border border-white/10">
                <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                <span class="text-white text-xs font-semibold uppercase">{{ $currentLang['code'] }}</span>
            </button>

            <div x-show="langOpen"
                style="display: none;"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute top-full right-0 mt-2 w-32 bg-black/80 backdrop-blur-md border border-white/10 rounded-lg shadow-xl overflow-hidden z-50">
                @foreach($languages as $lang)
                <a href="{{ route('lang.switch', $lang['code']) }}"
                    class="flex items-center gap-3 w-full px-4 py-3 text-sm text-left transition hover:bg-white/20
                       {{ $currentLocale === $lang['code'] ? 'text-blue-400 font-bold' : 'text-white' }}">
                    <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                    {{ $lang['name'] }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div id="slider-container" class="absolute inset-0 z-0">
        <template x-for="(slide, index) in slides" :key="index">
            <div class="slide-bg absolute inset-0 bg-cover bg-center"
                 :style="`background-image: url('${slide}');`"
                 x-show="activeSlide === index"
                 x-transition:enter="transition ease-in-out duration-1000"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in-out duration-1000"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-black/40"></div> </div>
        </template>
    </div>

    <div class="relative z-10 w-full max-w-100 p-8 mx-4 text-white">
        <div class="absolute inset-0 bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 shadow-2xl"></div>

        <div class="relative z-20 text-center px-4 py-6">
            
            <h1 class="text-4xl font-bold text-white mb-8 text-left">{{__('admin.login_title') }}</h1>
            <p class="text-gray-200 text-xs font-light mb-8 opacity-80 text-left">{{__('admin.login_message') }}</p>

            <form method="POST" action="{{ route('admin.login.submit') }}" @submit="isLoading = true" class="space-y-5">
                @csrf

                <div class="relative group">
                    <input type="email" name="email" placeholder="Email address"
                        class="w-full bg-transparent border border-white/30 rounded-lg py-3 px-4 text-white placeholder-gray-300 text-sm focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all"
                        required autofocus>
                    <span class="absolute right-4 top-3.5 text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </span>
                    @error('email')
                        <p class="text-red-300 text-xs text-left mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password dengan Toggle Mata -->
                <div class="relative group" x-data="{ showPassword: false }">
                    <input :type="showPassword ? 'text' : 'password'" 
                        name="password" 
                        placeholder="Password"
                        class="w-full bg-transparent border border-white/30 rounded-lg py-3 px-4 text-white placeholder-gray-300 text-sm focus:outline-none focus:border-white focus:ring-1 focus:ring-white transition-all pr-12"
                        required>
                    
                    <!-- Tombol Mata menggunakan flex items-center agar posisinya rata tengah -->
                    <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-300 hover:text-white focus:outline-none transition-colors">
                        
                        <!-- Icon Mata Terbuka -->
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                        <!-- Icon Mata Dicoret -->
                        <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>

                <button type="submit" class="w-full bg-[#0099FF] hover:bg-[#0066FF] text-white font-semibold py-3 px-4 rounded-lg shadow-lg transform active:scale-95 transition duration-200 mt-6">
                    {{__('admin.login_button') }}
                </button>
            </form>

            <div class="mt-6">
                <a href="{{ route('login') }}" class="text-xs text-gray-300 hover:text-white transition">{{__('admin.login_back') }}</a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-20 flex space-x-3">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index" 
                    class="h-1.5 w-8 rounded-full transition-all duration-300"
                    :class="activeSlide === index ? 'bg-white opacity-100' : 'bg-white opacity-40'">
            </button>
        </template>
    </div>

</body>
</html>