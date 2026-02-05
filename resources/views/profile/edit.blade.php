@php
// Logika Bahasa
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

<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('user.edit_title') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-[#F7F9FA] py-12 flex items-center justify-center"
        x-data="{ activeTab: 'account', langOpen: false }">

        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-[40px] shadow-sm p-8 flex flex-col md:flex-row gap-10 relative min-h-150">

                <x-front.sidebar-user />
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-2 gap-4">
                        <div class="flex items-center gap-2">
                            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ __('user.edit_setting') }}</h2>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="relative" @click.away="langOpen = false">
                                <button @click="langOpen = !langOpen" class="flex items-center gap-2 focus:outline-none hover:opacity-80 transition">
                                    <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-6 h-4 object-cover rounded-sm" />
                                    <span class="text-black text-xs font-semibold uppercase">{{ $currentLang['code'] }}</span>
                                </button>
                                <div x-show="langOpen" style="display: none;" class="absolute top-full right-0 mt-2 w-32 bg-black/80 backdrop-blur-md border border-white/10 rounded-lg shadow-xl overflow-hidden z-50">
                                    @foreach($languages as $lang)
                                    <a href="{{ route('lang.switch', $lang['code']) }}" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-left transition hover:bg-white/20 {{ $currentLocale === $lang['code'] ? 'text-blue-400 font-bold' : 'text-white' }}">
                                        <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                                        {{ $lang['name'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            <a href="/" class="flex items-center gap-2 bg-black text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-gray-800 transition duration-300">
                                {{ __('user.edit_back_button') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-8 border-b border-gray-200 mb-8">
                        <button @click="activeTab = 'account'" :class="activeTab === 'account' ? 'border-[#0099FF] text-[#0099FF]' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-4 pt-2 text-sm font-semibold border-b-2 transition duration-300">
                            {{ __('user.edit_account_info') }}
                        </button>
                        <button @click="activeTab = 'security'" :class="activeTab === 'security' ? 'border-[#0099FF] text-[#0099FF]' : 'border-transparent text-gray-500 hover:text-gray-700'" class="pb-4 pt-2 text-sm font-semibold border-b-2 transition duration-300">
                            {{ __('user.edit_pass_security') }}
                        </button>
                    </div>
                    <div x-show="activeTab === 'account'" x-transition.opacity>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    <div x-show="activeTab === 'security'" style="display: none;" x-transition.opacity>
                        @include('profile.partials.update-password-form')
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>