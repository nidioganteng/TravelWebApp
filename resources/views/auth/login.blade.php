<x-guest-layout>
    <!-- Tambahkan class 'relative' di sini agar tombol Toggle Role bisa melayang di pojok layar -->
    <div class="relative min-h-screen bg-white flex items-center justify-center p-4">
        
        {{-- ========================================================= --}}
        {{-- TOGGLE ROLE (USER | ADMIN) DI POJOK KANAN ATAS LAYAR      --}}
        {{-- ========================================================= --}}
        <div class="absolute top-6 right-6 z-50">
            <div class="flex items-center bg-gray-100 rounded-full p-1 border border-gray-200 shadow-sm">
                <!-- Tombol User -->
                <a href="{{ route('login') }}" 
                   class="px-6 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ request()->routeIs('login') ? 'bg-[#67a3bc] text-white shadow-md' : 'text-gray-500 hover:text-gray-800' }}">
                    User
                </a>

                <!-- Tombol Admin -->
                <a href="{{ route('admin.login') }}" 
                   class="px-6 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ request()->routeIs('admin.login') ? 'bg-[#67a3bc] text-white shadow-md' : 'text-gray-500 hover:text-gray-800' }}">
                    Admin
                </a>
            </div>
        </div>
        {{-- ========================================================= --}}


        <!-- KOTAK FORM UTAMA -->
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-5xl flex overflow-hidden min-h-150">

            <!-- BAGIAN KIRI: GAMBAR -->
            <div class="hidden md:block md:w-1/2 p-4">
                <div class="relative h-full w-full rounded-[15px] overflow-hidden group">
                    <img src="/img/login/assets/login_img.svg" alt="Scenery" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute bottom-8 left-8">
                        <img src="/img/login/icon/MijnIconWhite.svg" alt="Mijn Amor Icon" class="w-24">
                    </div>
                </div>
            </div>

            <!-- BAGIAN KANAN: FORM LOGIN -->
            <div class="w-full md:w-1/2 p-12 flex flex-col justify-between">

                <!-- Language Switcher -->
                <div class="flex justify-end mb-10">
                    @php
                    $languages = [
                        ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
                        ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
                        ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png'],
                        ['code' => 'de', 'name' => 'DE', 'flag' => 'https://flagcdn.com/w40/de.png'],
                        ['code' => 'fr', 'name' => 'FR', 'flag' => 'https://flagcdn.com/w40/fr.png']
                    ];
                    $currentLocale = app()->getLocale();
                    $currentLang = collect($languages)->firstWhere('code', $currentLocale) ?: $languages[0];
                    @endphp

                    <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                        <button @click="langOpen = !langOpen" class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
                            <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                            <span class="text-black text-sm font-bold uppercase">{{ $currentLang['code'] }}</span>
                        </button>
                        <div x-show="langOpen" style="display: none;" class="absolute top-full right-0 mt-2 w-32 bg-white border border-gray-100 rounded-lg shadow-xl overflow-hidden z-50">
                            @foreach($languages as $lang)
                            <a href="{{ route('lang.switch', $lang['code']) }}"
                                class="flex items-center gap-3 w-full px-4 py-3 text-sm text-left transition hover:bg-gray-50 {{ $currentLocale === $lang['code'] ? 'text-blue-500 font-bold' : 'text-gray-700' }}">
                                <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                                {{ $lang['name'] }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form Area -->
                <div class="my-auto">
                    <h1 class="text-[#67a3bc] text-5xl font-bold mb-2">{{ __('user.login_welcome') }}</h1>
                    <p class="text-gray-600 mb-8 font-medium">
                        {{ __('user.login_no_account') }} <a href="{{ route('register') }}" class="text-[#67a3bc] hover:underline">{{ __('user.login_register') }}</a>
                    </p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- @submit="isLoading = true" mengaktifkan loading screen -->
                    <form method="POST" action="{{ route('login') }}" @submit="isLoading = true" class="space-y-6">
                        @csrf

                        <!-- Input Email -->
                        <div>
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="{{ __('user.placeholder_email') }}" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Input Password (Dengan Fitur Toggle Mata) -->
                        <div x-data="{ showPassword: false }">
                            <div class="relative mt-1">
                                <x-text-input id="password" class="block w-full pr-12"
                                    ::type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="{{ __('user.placeholder_password') }}"
                                    required autocomplete="current-password" />

                                <button type="button" 
                                        @click="showPassword = !showPassword" 
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                    
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
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Forgot Password -->
                        <div class="flex items-center justify-start">
                            @if (Route::has('password.request'))
                            <a class="text-sm text-gray-600 hover:text-[#67a3bc]" href="{{ route('password.request') }}">
                                {{ __('user.login_forgot_password') }}
                            </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-[#67a3bc] text-white font-bold py-4 rounded-xl hover:bg-[#568da3] transition duration-300 uppercase tracking-wider text-lg shadow-md">
                            {{ __('user.login_sign_in') }}
                        </button>
                    </form>
                </div>

                <div class="h-4"></div>
            </div>

        </div>
    </div>
</x-guest-layout>