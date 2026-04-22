<x-admin-layout>
    {{-- 1. LOGIKA PHP BAHASA --}}
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

    {{-- 2. HEADER --}}
    <div class="bg-white py-6 md:py-9 px-4 md:px-8 shadow-md border-b border-gray-100 mb-8 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl md:text-3xl font-bold text-black tracking-tight">{{ __('admin.users_title') }}</h1>
            
            {{-- Badge Total User (Desktop) --}}
            <span class="bg-[#EEF8FF] text-[#0099FF] py-1 px-3 rounded-full text-xs font-bold border border-blue-100 hidden sm:block">
                {{ __('admin.users_total') }} {{ $users->total() }} {{ __('admin.users_users') }}
            </span>
        </div>

        {{-- LANGUAGE SELECTOR (Desktop Only) --}}
        <div class="hidden lg:block"> 
            <div class="relative" x-data="{ langOpen: false }" @click.away="langOpen = false">
                <button 
                    @click="langOpen = !langOpen"
                    class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 border border-gray-200 px-3 py-2 rounded-lg transition-colors focus:outline-none">
                    <img src="{{ $currentLang['flag'] }}" alt="{{ $currentLang['name'] }}" class="w-5 h-3 object-cover rounded-sm shadow-sm" />
                    <span class="text-xs font-bold uppercase text-gray-700">{{ $currentLang['code'] }}</span>
                    <i class="fas fa-chevron-down text-[10px] opacity-80 text-gray-500" :class="langOpen ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="langOpen"
                    style="display: none;"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute top-full right-0 mt-2 w-32 bg-white rounded-lg shadow-xl z-50 overflow-hidden border border-gray-100">
                    @foreach($languages as $lang)
                    <a href="{{ route('lang.switch', $lang['code']) }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-left transition hover:bg-gray-50
                            {{ $currentLocale === $lang['code'] ? 'text-[#0099FF] font-bold bg-blue-50' : 'text-gray-700' }}">
                        <img src="{{ $lang['flag'] }}" alt="{{ $lang['name'] }}" class="w-5 h-3 object-cover rounded-sm" />
                        {{ $lang['name'] }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- 3. KONTEN UTAMA (Modular) --}}
    <div class="px-4 md:px-8 pb-8 space-y-12"> {{-- space-y-12 memberi jarak antar kotak --}}
        
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight mb-4">User Activity List</h2>
            @include('admin.users.activity')
        </div>

    </div>
</x-admin-layout>