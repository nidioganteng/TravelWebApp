<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 px-4">
        <div class="relative flex flex-col md:flex-row min-h-112.5 items-center justify-center bg-white rounded-3xl overflow-hidden shadow-sm p-8 max-w-5xl mx-auto">
            <div class="w-full md:w-1/2 p-6 flex flex-col justify-center">
                <div class="mb-6">
                    <h1 class="text-4xl font-extrabold text-[#87B8BE] mb-2">
                        {{ __('user.forgot_password_title') }}

                    </h1>
                    <p class="text-sm text-gray-500">
                        {{ __('user.forgot_password_desc') }}
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" @submit="isLoading = true" class="space-y-6">
                    @csrf

                    <div class="mb-4">
                        <x-text-input
                            id="email"
                            class="block w-full bg-gray-200 border-none rounded-lg p-4 placeholder-gray-400 focus:ring-2 focus:ring-blue-100"
                            type="email"
                            name="email"
                            :value="old('email')"
                            placeholder="{{ __('user.placeholder_email') }}"
                            required
                            autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="w-full bg-[#87B8BE] hover:bg-[#92d7e0] text-white font-bold py-4 px-4 rounded-xl transition duration-200 shadow-lg shadow-[#87B8BE] tracking-tight text-sm">
                            {{ __('user.forgot_password_button') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="hidden md:flex w-full md:w-1/2 justify-center items-center p-6">
                <div class="w-full flex justify-center">
                    <img src="/img/login/assets/forgot_password.svg" alt="Illustration" class="max-w-[80%] h-auto">
                </div>
            </div>
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
        </div>
    </div>
</x-guest-layout>