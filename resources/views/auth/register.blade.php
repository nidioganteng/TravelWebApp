<x-auth-split-layout>

    {{-- Language Switcher --}}
    @php
        $languages    = [
            ['code' => 'en', 'name' => 'EN', 'flag' => 'https://flagcdn.com/w40/us.png'],
            ['code' => 'id', 'name' => 'ID', 'flag' => 'https://flagcdn.com/w40/id.png'],
            ['code' => 'nl', 'name' => 'NL', 'flag' => 'https://flagcdn.com/w40/nl.png'],
            ['code' => 'de', 'name' => 'DE', 'flag' => 'https://flagcdn.com/w40/de.png'],
            ['code' => 'pt', 'name' => 'PT', 'flag' => 'https://flagcdn.com/w40/pt.png'],
        ];
        $currentLocale = app()->getLocale();
        $currentLang   = collect($languages)->firstWhere('code', $currentLocale) ?? $languages[0];
    @endphp

    <div class="relative mb-6 flex justify-end" x-data="{ langOpen: false }" @click.away="langOpen = false">
        <button @click="langOpen = !langOpen"
                class="flex cursor-pointer items-center gap-2 transition hover:opacity-80 focus:outline-none">
            <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="h-4 w-6 rounded-sm object-cover" />
            <span class="text-sm font-bold uppercase text-gray-800">{{ $currentLang['code'] }}</span>
        </button>
        <div x-show="langOpen" style="display:none;"
             class="absolute right-0 top-full z-50 mt-2 w-32 overflow-hidden rounded-lg border border-gray-100 bg-white shadow-xl">
            @foreach($languages as $lang)
            <a href="{{ route('lang.switch', $lang['code']) }}"
               class="flex w-full items-center gap-3 px-4 py-3 text-left text-sm transition hover:bg-gray-50 {{ $currentLocale === $lang['code'] ? 'font-bold text-blue-500' : 'text-gray-700' }}">
                <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="h-3 w-5 rounded-sm object-cover" />
                {{ $lang['name'] }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Heading --}}
    <div class="mb-7">
        <h1 class="text-3xl font-bold text-gray-900">{{ __('user.register_create') }}</h1>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('user.register_confirmation') }}
            <a href="{{ route('login') }}" class="font-semibold text-[#67a3bc] hover:underline">
                {{ __('user.register_login') }}
            </a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" @submit="isLoading = true" class="space-y-5">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700">
                {{ __('Name') }}
            </label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="{{ __('user.register_name_placeholder') }}"
                   required
                   autofocus
                   autocomplete="name"
                   class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-gray-900 placeholder-gray-400 transition-colors focus:border-[#67a3bc] focus:outline-none focus:ring-2 focus:ring-[#67a3bc]/30">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">
                {{ __('Email') }}
            </label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="{{ __('user.placeholder_email') }}"
                   required
                   autocomplete="email"
                   class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-gray-900 placeholder-gray-400 transition-colors focus:border-[#67a3bc] focus:outline-none focus:ring-2 focus:ring-[#67a3bc]/30">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div x-data="{ showPassword: false }">
            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">
                {{ __('Password') }}
            </label>
            <div class="relative">
                <input id="password"
                       ::type="showPassword ? 'text' : 'password'"
                       name="password"
                       placeholder="{{ __('user.placeholder_password') }}"
                       required
                       autocomplete="new-password"
                       class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 pr-12 text-gray-900 placeholder-gray-400 transition-colors focus:border-[#67a3bc] focus:outline-none focus:ring-2 focus:ring-[#67a3bc]/30">
                <button type="button"
                        @click="showPassword = !showPassword"
                        :aria-label="showPassword ? 'Hide password' : 'Show password'"
                        class="absolute inset-y-0 right-0 flex cursor-pointer items-center pr-4 text-gray-400 transition-colors hover:text-gray-600 focus:outline-none">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg x-show="showPassword" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div x-data="{ showConfirm: false }">
            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">
                {{ __('Confirm Password') }}
            </label>
            <div class="relative">
                <input id="password_confirmation"
                       ::type="showConfirm ? 'text' : 'password'"
                       name="password_confirmation"
                       placeholder="{{ __('user.register_confirm_placeholder') }}"
                       required
                       autocomplete="new-password"
                       class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 pr-12 text-gray-900 placeholder-gray-400 transition-colors focus:border-[#67a3bc] focus:outline-none focus:ring-2 focus:ring-[#67a3bc]/30">
                <button type="button"
                        @click="showConfirm = !showConfirm"
                        :aria-label="showConfirm ? 'Hide password' : 'Show password'"
                        class="absolute inset-y-0 right-0 flex cursor-pointer items-center pr-4 text-gray-400 transition-colors hover:text-gray-600 focus:outline-none">
                    <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg x-show="showConfirm" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Terms checkbox --}}
        <div class="flex items-center gap-2 py-1">
            <input id="terms"
                   type="checkbox"
                   name="terms"
                   required
                   class="cursor-pointer rounded border-gray-300 text-[#67a3bc] focus:ring-[#67a3bc]">
            <label for="terms" class="cursor-pointer select-none text-sm text-gray-600">
                {{ __('user.register_agreement_account') }}
            </label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="mt-2 w-full cursor-pointer rounded-full bg-[#111] py-4 text-base font-semibold tracking-wide text-white transition-colors hover:bg-[#2a2a2a] active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-60"
                x-bind:disabled="isLoading">
            {{ __('Register') }}
        </button>
    </form>

</x-auth-split-layout>
