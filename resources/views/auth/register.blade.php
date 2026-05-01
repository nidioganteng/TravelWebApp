<x-guest-layout>
    <div class="min-h-screen bg-white flex items-center justify-center p-4">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-5xl flex overflow-hidden min-h-150 bg-shadow-lg">

            <div class="w-full md:w-1/2 p-12 flex flex-col">
                <div class="flex justify-start mb-10">
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

                    <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                        <button @click="langOpen = !langOpen" class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
                            <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                            <span class="text-black text-sm font-bold uppercase">{{ $currentLang['code'] }}</span>
                        </button>
                        <div x-show="langOpen" style="display: none;" class="absolute top-full left-0 mt-2 w-32 bg-white border border-gray-100 rounded-lg shadow-xl overflow-hidden z-50">
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

                <div class="my-auto">
                    <h1 class="text-[#67a3bc] text-5xl font-bold mb-2">{{ __('user.register_create') }}</h1>
                    <p class="text-gray-600 mb-8 font-medium">
                       {{ __('user.register_confirmation') }} <a href="{{ route('login') }}" class="text-[#67a3bc] hover:underline">{{ __('user.register_login') }}</a>
                    </p>

                    <form method="POST" action="{{ route('register') }}" @submit="isLoading = true" class="space-y-6">
                        @csrf

                        <div>
                            <x-text-input id="name"
                                type="text"
                                name="name"
                                placeholder="Name"
                                value="{{ old('name') }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-text-input id="email"
                                type="email"
                                name="email"
                                placeholder="Email"
                                value="{{ old('email') }}" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Input Password Utama dengan Toggle Mata -->
                        <div x-data="{ showPassword: false }">
                            <div class="relative mt-1">
                                <x-text-input id="password" class="block w-full pr-12"
                                    ::type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Password"
                                    value="{{ old('password') }}" required autocomplete="new-password" />
                                    
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

                        <!-- Input Confirm Password dengan Toggle Mata Sendiri -->
                        <div x-data="{ showPassword: false }">
                            <div class="relative mt-1">
                                <x-text-input id="password_confirmation" class="block w-full pr-12"
                                    ::type="showPassword ? 'text' : 'password'"
                                    name="password_confirmation"
                                    placeholder="Confirm Password"
                                    value="{{ old('password_confirmation') }}" required autocomplete="new-password" />
                                    
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
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Checkbox Konfirmasi Pembuatan Akun -->
                        <div class="flex items-center gap-2 py-2">
                            <input id="terms" type="checkbox" name="terms" required class="rounded border-gray-300 text-[#67a3bc] focus:ring-[#67a3bc] cursor-pointer">
                            <label for="terms" class="text-sm text-gray-600 cursor-pointer select-none">
                                {{ __('user.register_agreement_account') }}
                            </label>
                        </div>
                        
                        <x-primary-button type="submit">
                            {{ __('Register') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>

            <div class="hidden md:block md:w-1/2 p-4">
                <div class="relative h-full w-full rounded-[15px] overflow-hidden group">
                    <img src="/img/register/assets/register_img.svg" alt="Scenery" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute bottom-8 right-8">
                        <img src="/img/register/icon/MijnIconWhite.svg" alt="Mijn Amor Icon" class="w-24">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>