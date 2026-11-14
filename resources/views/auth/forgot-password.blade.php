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

    <div class="mb-6 flex justify-end" x-data="{ langOpen: false }" @click.away="langOpen = false">
        <button @click="langOpen = !langOpen"
                class="flex cursor-pointer items-center gap-2 transition hover:opacity-80 focus:outline-none">
            <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="h-4 w-6 rounded-sm object-cover" />
            <span class="text-sm font-bold uppercase text-gray-800">{{ $currentLang['code'] }}</span>
        </button>
        <div x-show="langOpen" style="display:none;"
             class="absolute right-6 top-16 z-50 w-32 overflow-hidden rounded-lg border border-gray-100 bg-white shadow-xl lg:right-10 lg:top-14">
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
        <h1 class="text-3xl font-bold text-gray-900">{{ __('user.forgot_password_title') }}</h1>
        <p class="mt-2 text-sm leading-relaxed text-gray-500">
            {{ __('user.forgot_password_desc') }}
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" @submit="isLoading = true" class="space-y-5">
        @csrf

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
                   autofocus
                   autocomplete="email"
                   class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3.5 text-gray-900 placeholder-gray-400 transition-colors focus:border-[#67a3bc] focus:outline-none focus:ring-2 focus:ring-[#67a3bc]/30">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="mt-2 w-full cursor-pointer rounded-full bg-[#111] py-4 text-base font-semibold tracking-wide text-white transition-colors hover:bg-[#2a2a2a] active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-60"
                x-bind:disabled="isLoading">
            {{ __('user.forgot_password_button') }}
        </button>
    </form>

    {{-- Back to login --}}
    <p class="mt-6 text-center text-sm text-gray-500">
        <a href="{{ route('login') }}" class="font-semibold text-[#67a3bc] hover:underline">
            ← {{ __('user.register_login') }}
        </a>
    </p>

</x-auth-split-layout>
