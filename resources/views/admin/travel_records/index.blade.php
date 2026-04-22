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
        <h1 class="text-2xl md:text-3xl font-bold text-black tracking-tight">
                {{ __('admin.track_record_index_title') }}
        </h1>

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


    <div class="p-5 md:p-8 lg:p-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4"> 
            <div class="flex items-center gap-2">
                <h2 class="text-lg md:text-xl font-bold text-[#0099FF]">{{ __('admin.track_record_recent_title') }}</h2>
                <i class="fas fa-chevron-right text-[#0099FF] text-xs"></i>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                <form action="{{ route('admin.travel-records.index') }}" method="GET" class="flex-1 md:flex-none">
                    <div class="relative w-full">
                        <select name="year" onchange="this.form.submit()" class="w-full appearance-none bg-white border border-gray-200 text-black font-bold py-2.5 pl-5 pr-10 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition focus:outline-none text-xs md:text-sm md:min-w-37.5">
                            <option value="">{{ __('admin.track_record_filter_all_years') }}</option>
                            @for ($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-black">
                            <i class="fas fa-chevron-down text-[10px] md:text-xs"></i>
                        </div>
                    </div>
                </form>

                <a href="{{ route('admin.travel-records.create') }}" class="bg-[#0099FF] text-white w-10 h-10 rounded-full flex items-center justify-center shadow-md hover:bg-blue-700 transition shrink-0" title="{{ __('admin.track_record_tooltip_add') }}">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative mb-6 flex justify-between items-center text-xs md:text-sm">
                <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-700 font-bold p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            
            @forelse($travelRecords as $record)
                <div class="bg-white rounded-[25px] shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                    
                    <div class="relative h-44 md:h-48 overflow-hidden">
                        <img loading="lazy" src="{{ Storage::url($record->banner_image) }}" alt="{{ $record->city_name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-extrabold text-[#0099FF] shadow-sm">
                            {{ $record->year }}
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-base md:text-lg font-bold text-black mb-2 group-hover:text-[#0099FF] transition">{{ $record->city_name }}</h3>
                        <p class="text-gray-500 text-[11px] md:text-xs leading-relaxed mb-5 line-clamp-3 flex-1">
                            {{ $record->description }}
                        </p>

                        <div class="flex items-center gap-2 mt-auto">
                            <a href="{{ route('track-record.show', $record->slug) }}" class="bg-[#1F2937] text-white px-3 py-2.5 rounded-xl text-[10px] font-bold hover:bg-black transition flex-1 text-center">
                                {{ __('admin.track_record_btn_view') }}
                            </a>

                            <a href="{{ route('admin.travel-records.edit', $record->id) }}" class="bg-[#0099FF] text-white px-3 py-2.5 rounded-xl text-[10px] font-bold hover:bg-blue-600 transition">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.travel-records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('{{ __('admin.track_record_confirm_delete') }}');" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#FF0000] text-white px-3 py-2.5 rounded-xl text-[10px] font-bold hover:bg-red-600 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 text-center text-gray-400 flex flex-col items-center bg-white rounded-[30px] border-2 border-dashed border-gray-100 mx-2">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-folder-open text-4xl text-gray-200"></i>
                    </div>
                    <p class="text-base md:text-lg font-medium text-gray-500">{{ __('admin.track_record_empty_state') }}</p>
                    <a href="{{ route('admin.travel-records.create') }}" class="mt-4 bg-[#0099FF] text-white px-6 py-2 rounded-full text-sm font-bold shadow-md hover:bg-blue-600 transition">
                        {{ __('admin.track_record_btn_create_new') }}
                    </a>
                </div>
            @endforelse

        </div>

    </div>
</x-admin-layout>