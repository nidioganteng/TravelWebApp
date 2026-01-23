<x-guest-layout>
    <div class="min-h-screen bg-white flex items-center justify-center p-4">
        <div class="bg-white rounded-[20px] shadow-2xl w-full max-w-5xl flex overflow-hidden min-h-150">

            <div class="hidden md:block md:w-1/2 p-4">
                <div class="relative h-full w-full rounded-[15px] overflow-hidden group">
                    <img src="/img/login/assets/login_img.svg" alt="Scenery" class="absolute inset-0 w-full h-full object-cover">

                    <a href="/" class="absolute top-6 right-6 bg-black text-white px-5 py-2 rounded-full text-sm font-medium flex items-center gap-2 hover:bg-gray-800 transition">
                        back to website
                        <span>&rarr;</span>
                    </a>

                    <div class="absolute bottom-8 left-8">
                        <img src="/img/login/icon/MijnIconWhite.svg" alt="Mijn Amor Icon" class="w-24">
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-12 flex flex-col justify-between">
                
                <div class="flex justify-end mb-10">
                    @php
                    $languages = [
                        ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
                        ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
                        ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png']
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

                <div class="my-auto">
                    <h1 class="text-[#67a3bc] text-5xl font-bold mb-2">Welcome back!</h1>
                    <p class="text-gray-600 mb-8 font-medium">
                        Don't have an account? <a href="{{ route('register') }}" class="text-[#67a3bc] hover:underline">Create Account</a>
                    </p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-start">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-gray-600 hover:text-[#67a3bc]" href="{{ route('password.request') }}">
                                    {{ __('Forget password?') }}
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="w-full bg-[#67a3bc] text-white font-bold py-4 rounded-xl hover:bg-[#568da3] transition duration-300 uppercase tracking-wider text-lg shadow-md">
                            Sign In
                        </button>
                    </form>
                </div>
                
                <div class="h-4"></div>
            </div>

        </div>
    </div>
</x-guest-layout>