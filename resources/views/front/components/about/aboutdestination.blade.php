<div>
    {{-- HEADER SECTION (TETAP SAMA) --}}
    <div class="text-center max-w-7xl mx-auto section-spacing">
        <h1 class="text-xl md:text-[48px] font-extrabold text-black mb-4 leading-tight">
            {{ __('about_destination.section') }}
        </h1>

        <p class="text-gray-600 text-[8px] sm:text-[10px] md:text-[12px] lg:text-sm leading-relaxed max-w-3xl md:max-w-7xl mx-auto">
            {{ __('about_destination.desc') }}
        </p>
    </div>

    {{-- CONTAINER KARTU --}}
    <div class="flex flex-col items-center justify-center py-10 md:py-20 px-4 w-screen relative left-1/2 -translate-x-1/2">
        
        {{-- FILTER TAHUN --}}
        <div class="w-full flex justify-start mb-10 md:max-w-362.5 px-2">
            <form action="{{ route('about') }}" method="GET" class="relative group z-20">
                
                {{-- UI Visual --}}
                <div class="flex items-center gap-3 bg-white pl-3 pr-6 py-3 rounded-full shadow-lg border border-gray-100 cursor-pointer hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <div class="bg-black text-white w-8 h-8 rounded-full flex items-center justify-center text-xs shadow-md">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    
                    {{-- Teks Tahun Dinamis --}}
                    <span class="font-bold text-gray-900 text-lg tracking-wide">
                        {{-- Jika selectedYear kosong, berarti "All Years". Jika ada isinya, tampilkan tahunnya --}}
                        {{ $selectedYear ? $selectedYear : 'All Years' }}
                    </span>
                </div>

                {{-- Select Dropdown --}}
                <select name="year" onchange="this.form.submit()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    {{-- Opsi All Years --}}
                    <option value="" {{ $selectedYear == '' ? 'selected' : '' }}>All Years</option>
                    
                    {{-- Opsi Loop Tahun (Dari Controller: Skrng - 2018) --}}
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

            </form>
        </div>

        <div class="flex flex-wrap justify-center gap-6 md:gap-8 w-full max-w-360">

            {{-- LOOPING DATA --}}
            @foreach($trackRecords as $record)
                <div class="w-full max-w-100 lg:max-w-112.5 bg-[#ffffff] rounded-md overflow-hidden shadow-2xl pb-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer flex flex-col group">
                    {{-- Gambar --}}
                    <div class="h-56 sm:h-64 md:h-70 w-full overflow-hidden">
                        <img 
                            src="{{ Storage::url($record->banner_image) }}" 
                            alt="{{ $record->city_name }}" 
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                        />
                    </div>
                    {{-- Konten --}}
                    <div class="px-5 md:px-6 pt-5 grow flex flex-col">
                        <div class="flex justify-between items-start mb-2">
                            <h2 class="font-bold text-xl md:text-2xl text-black">{{ $record->city_name }}</h2>
                            <span class="text-xs font-bold text-[#123E5E] bg-blue-50 px-2 py-1 rounded">{{ $record->year }}</span>
                        </div>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed grow">
                            {{ Str::limit($record->description, 120) }}
                        </p>
                        <div class="mt-auto">
                            <a href="{{ route('track-record.show', $record->slug) }}" class="block w-full sm:w-auto">
                                <button class="bg-[#123E5E] text-white text-sm md:text-base font-semibold py-2.5 px-6 md:px-8 rounded-full hover:bg-opacity-90 transition duration-300 w-full">
                                    {{ __('herabout.button') }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- PESAN JIKA DATA KOSONG --}}
            @if($trackRecords->isEmpty())
                <div class="text-center py-20 w-full">
                    <div class="inline-block p-4 rounded-full bg-gray-100 mb-3">
                        <i class="fas fa-search text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 font-medium text-lg">Tidak ada perjalanan di tahun {{ $selectedYear }}.</p>
                    <p class="text-gray-400 text-sm">Coba pilih tahun lain atau "All Years".</p>
                </div>
            @endif

        </div>
    </div>
</div>