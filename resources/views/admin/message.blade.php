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
        <h1 class="text-2xl md:text-3xl font-bold text-black tracking-tight">{{ __('admin.message_title') }}</h1>

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

    <div class="px-4 md:px-8 pb-8">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div x-data="{ selected: null }" class="flex flex-col lg:flex-row gap-6 relative items-start">
        
        <div class="bg-white rounded-[20px] shadow-md border border-gray-100 flex flex-col transition-all duration-500 ease-in-out overflow-hidden w-full"
            :class="selected ? 'lg:w-7/12' : 'w-full'">
            
            {{-- 
                PERBAIKAN GRID HEADER:
                Total harus 12.
                From (3) + Email (4) + Received (3) + Action (2) = 12
            --}}
            <div class="hidden md:grid grid-cols-12 px-6 py-4 border-b border-gray-100 bg-[#EEF8FF] text-gray-400 font-medium text-sm">
                <div class="col-span-3">{{ __('admin.message_table_from') }}</div>
                <div class="col-span-4">{{ __('admin.message_table_email') }}</div>
                <div class="col-span-3">{{ __('admin.message_table_received') }}</div>
                <div class="col-span-2 text-right">{{ __('admin.message_table_action') }}</div> {{-- Ubah jadi 2 dan text-right --}}
            </div>

            <div class="flex flex-col">
                @forelse($messages as $msg)
                    {{-- 
                        PERBAIKAN GRID BODY (Agar lurus dengan Header):
                        From (3) + Email (4) + Received (3) + Action (2) = 12
                    --}}
                    <div class="flex flex-col md:grid md:grid-cols-12 items-start md:items-center px-6 py-5 border-b border-gray-50 hover:bg-blue-50/30 transition last:border-0">
                        <div class="md:col-span-3 overflow-hidden pr-2 w-full mb-1 md:mb-0">
                            <h3 class="font-bold md:font-medium text-gray-800 text-sm md:text-base truncate">{{ $msg->name }}</h3>
                        </div>
                        <div class="md:col-span-4 text-xs md:text-sm text-gray-600 truncate pr-2 w-full mb-2 md:mb-0"> {{-- Ubah jadi 4 --}}
                            {{ $msg->email }}
                        </div>

                        <div class="md:col-span-3 text-xs md:text-sm text-gray-500 mb-3 md:mb-0">
                            <span class="bg-gray-100 px-2 py-1 rounded-md text-[10px] md:text-xs font-medium">
                                <i class="far fa-clock md:hidden mr-1"></i> {{ $msg->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>

                        <div class="md:col-span-2 flex gap-2 w-full md:w-auto md:justify-end"> {{-- Ubah jadi 2 dan justify-end --}}
                            <button @click="selected = {{ $msg }}" 
                                    class="flex-1 md:flex-none justify-center bg-[#0099FF] text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-600 transition flex items-center gap-2 shadow-blue-200 shadow-md whitespace-nowrap">
                                {{ __('admin.message_btn_view') }} <span class="hidden md:inline">{{ __('admin.message_btn_all') }}</span> <i class="fas fa-caret-right"></i>
                            </button>

                            <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('{{ __('admin.message_alert_delete') }}');" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#FF4D4F] text-white px-3 py-2 rounded-lg text-xs hover:bg-red-600 transition shadow-red-200 shadow-md">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="py-12 flex flex-col items-center justify-center text-center text-gray-400 px-4">
                        <i class="fas fa-inbox text-5xl mb-4 text-gray-200"></i>
                        <p class="text-sm">{{ __('admin.message_empty') }}</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="fixed inset-0 z-100 p-4 flex items-center justify-center bg-black/50 lg:bg-transparent lg:relative lg:inset-auto lg:z-10 lg:p-0 transition-all duration-500 ease-in-out"
             x-show="selected" 
             x-cloak
             :class="selected ? 'opacity-100 visible' : 'opacity-0 invisible lg:hidden lg:w-0'">
            
            <div class="bg-white rounded-xl shadow-2xl lg:shadow-md border border-gray-200 overflow-hidden w-full max-w-lg lg:max-w-none lg:sticky lg:top-6"
                 @click.away="if(window.innerWidth < 1024) selected = null">

                <div class="bg-[#EEF8FF] p-5 md:p-6 border-b border-gray-200 flex justify-between items-start">
                    <div class="flex items-center gap-4 overflow-hidden">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full border border-gray-200 bg-white text-[#0099FF] shrink-0 flex items-center justify-center font-bold text-lg md:text-xl">
                            <span x-text="selected?.name?.substring(0,2).toUpperCase()"></span>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base md:text-lg font-bold text-gray-900 truncate" x-text="selected?.name"></h2>
                            <a :href="'mailto:' + selected?.email" class="text-xs md:text-sm text-[#0099FF] hover:underline truncate block" x-text="selected?.email"></a>
                        </div>
                    </div>

                    <button @click="selected = null" class="text-gray-400 hover:text-red-500 transition p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-5 md:p-6 bg-white">
                    <h3 class="font-bold text-gray-800 mb-2 text-xs md:text-sm uppercase tracking-wider">{{ __('admin.message_detail_label') }}</h3>

                    <div class="bg-gray-50 p-4 rounded-xl text-gray-600 text-sm leading-relaxed whitespace-pre-line border border-gray-100 min-h-37.5 max-h-75 overflow-y-auto" 
                         x-text="selected?.message">
                    </div>

                    <div class="mt-4 text-right">
                        <span class="text-[10px] md:text-xs text-gray-400 italic">
                            {{ __('admin.message_detail_sent') }} <span x-text="new Date(selected?.created_at).toLocaleDateString('{{ app()->getLocale() }}', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
</x-admin-layout>