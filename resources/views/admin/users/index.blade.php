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

    {{-- 3. KONTEN UTAMA --}}
    <div class="px-4 md:px-8 pb-8">
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Badge Total User (Mobile) --}}
        <div class="mb-4 sm:hidden">
            <span class="bg-[#EEF8FF] text-[#0099FF] py-1 px-3 rounded-full text-xs font-bold border border-blue-100">
                {{ __('admin.users_total') }} {{ $users->total() }} {{ __('admin.users_users') }}
            </span>
        </div>

        {{-- TABEL PENGGUNA --}}
        <div class="bg-white rounded-[20px] shadow-md border border-gray-100 flex flex-col overflow-hidden w-full">
            
            {{-- HEADER TABEL --}}
            <div class="hidden md:grid grid-cols-12 px-6 py-4 border-b border-gray-100 bg-[#EEF8FF] text-gray-400 font-medium text-sm uppercase tracking-wider text-[11px]">
                <div class="col-span-3">{{ __('admin.users_table_user') }}</div>
                <div class="col-span-3">{{ __('admin.users_table_last_active') }}</div>
                <div class="col-span-2">{{ __('admin.users_table_last_page') }}</div>
                <div class="col-span-2">{{ __('admin.users_table_ip') }}</div>
                <div class="col-span-2">{{ __('admin.users_table_status') }}</div>
            </div>

            {{-- BODY TABEL --}}
            <div class="flex flex-col">
                @forelse($users as $user)
                    <div class="flex flex-col md:grid md:grid-cols-12 items-start md:items-center px-6 py-5 border-b border-gray-50 hover:bg-blue-50/30 transition last:border-0">
                        
                        {{-- 1. Info User --}}
                        <div class="md:col-span-3 flex items-center gap-3 w-full mb-4 md:mb-0 overflow-hidden pr-2">
                            <div class="w-10 h-10 rounded-full bg-[#0099FF] text-white flex items-center justify-center font-bold shrink-0 shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="font-bold text-gray-900 text-sm md:text-base truncate">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $user->email }}</div>
                            </div>
                        </div>

                        {{-- 2. Terakhir Aktif --}}
                        <div class="md:col-span-3 text-xs md:text-sm text-gray-600 w-full mb-2 md:mb-0 pr-2">
                            <span class="md:hidden font-bold text-gray-400 uppercase text-[10px] block mb-1">{{ __('admin.users_table_last_active') }}:</span>
                            @if($user->last_seen_at)
                                <span class="font-medium text-gray-800">{{ $user->last_seen_at->diffForHumans() }}</span>
                                <div class="text-[10px] text-gray-400 mt-0.5"><i class="far fa-clock mr-1"></i>{{ $user->last_seen_at->format('d M Y, H:i') }}</div>
                            @else
                                <span class="text-gray-400 italic bg-gray-50 px-2 py-1 rounded-md text-[10px]">{{ __('admin.users_status_undetected') }}</span>
                            @endif
                        </div>

                        {{-- 3. Halaman Terakhir --}}
                        <div class="md:col-span-2 text-xs md:text-sm text-gray-500 w-full mb-2 md:mb-0 pr-2">
                            <span class="md:hidden font-bold text-gray-400 uppercase text-[10px] block mb-1">{{ __('admin.users_mobile_page') }}</span>
                            <code class="text-[11px] bg-[#EEF8FF] px-2 py-1 rounded-md text-[#0099FF] font-medium border border-blue-100">
                                /{{ $user->last_page ?? '-' }}
                            </code>
                        </div>

                        {{-- 4. IP Address --}}
                        <div class="md:col-span-2 text-xs md:text-sm text-gray-500 w-full mb-2 md:mb-0 pr-2">
                            <span class="md:hidden font-bold text-gray-400 uppercase text-[10px] block mb-1">{{ __('admin.users_table_ip') }}:</span>
                            {{ $user->last_ip ?? '-' }}
                        </div>

                        {{-- 5. Status Online/Offline --}}
                        <div class="md:col-span-2 w-full flex md:block items-center justify-between mt-2 md:mt-0">
                            <span class="md:hidden font-bold text-gray-400 uppercase text-[10px]">{{ __('admin.users_table_status') }}:</span>
                            @if($user->last_seen_at && $user->last_seen_at->diffInMinutes(now()) < 5)
                                <span class="inline-flex items-center gap-1.5 text-green-600 text-[11px] font-bold bg-green-50 px-2.5 py-1 rounded-full border border-green-100">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> {{ __('admin.users_status_online') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-gray-500 text-[11px] font-medium bg-gray-50 px-2.5 py-1 rounded-full border border-gray-200">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span> {{ __('admin.users_status_offline') }}
                                </span>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="py-12 flex flex-col items-center justify-center text-center text-gray-400 px-4">
                        <i class="fas fa-users text-5xl mb-4 text-gray-200"></i>
                        <p class="text-sm">{{ __('admin.users_empty') }}</p>
                    </div>
                @endforelse
            </div>
            
            {{-- PAGINATION --}}
            @if($users->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $users->links() }}
                </div>
            @endif

        </div>
    </div>
</x-admin-layout>