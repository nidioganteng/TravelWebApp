<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 px-4">
        <div class="relative flex flex-col md:flex-row min-h-112.5 items-center justify-center bg-white rounded-3xl overflow-hidden shadow-sm p-8 max-w-5xl mx-auto">

            {{-- Sisi Kiri: Form Forgot Password --}}
            <div class="w-full md:w-1/2 p-6 flex flex-col justify-center">
                <div class="mb-6">
                    <h1 class="text-4xl font-extrabold text-[#0099FF] mb-2">
                        {{ __('Forget Password') }}
                    </h1>
                    <p class="text-sm text-gray-500">
                        {{ __('Forget password? No Problem. Just let us know your email address') }}
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <x-text-input
                            id="email"
                            class="block w-full bg-gray-200 border-none rounded-lg p-4 placeholder-gray-400 focus:ring-2 focus:ring-blue-400"
                            type="email"
                            name="email"
                            :value="old('email')"
                            placeholder="Email"
                            required
                            autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="w-full bg-[#0099FF] hover:bg-blue-600 text-white font-bold py-4 px-4 rounded-xl transition duration-200 shadow-lg shadow-blue-200 tracking-tight text-sm">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Sisi Kanan: Tempat Ilustrasi --}}
            <div class="hidden md:flex w-full md:w-1/2 justify-center items-center p-6">
                <div class="w-full flex justify-center">
                    <img src="/img/login/assets/forgot_password.svg" alt="Illustration" class="max-w-[80%] h-auto">
                </div>
            </div>

            {{-- LANGUAGE SELECTOR (Top Right) --}}
            @php
            $languages = [
            ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
            ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
            ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png']
            ];

            $currentLocale = app()->getLocale();
            $currentLang = collect($languages)->firstWhere('code', $currentLocale) ?: $languages[0];
            @endphp

            <div class="absolute top-8 right-8" x-data="{ langOpen: false }" @click.away="langOpen = false">
                <button
                    @click="langOpen = !langOpen"
                    class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition group">
                    <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm shadow-sm" />
                    <span class="text-gray-800 text-sm font-bold uppercase">{{ $currentLang['code'] }}</span>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div x-show="langOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    style="display: none;"
                    class="absolute top-full right-0 mt-2 w-32 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden z-50">
                    @foreach($languages as $lang)
                    <a href="{{ route('lang.switch', $lang['code']) }}"
                        class="flex items-center gap-3 w-full px-4 py-3 text-sm text-left transition hover:bg-gray-50
                       {{ $currentLocale === $lang['code'] ? 'text-blue-500 font-bold' : 'text-gray-700' }}">
                        <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                        {{ $lang['name'] }}
                    </a>
                    @endforeach
                </div>
            </div>
            {{-- END LANGUAGE SELECTOR --}}

        </div>
    </div>
</x-guest-layout>