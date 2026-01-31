<x-admin-layout>

    <div class="flex items-center gap-4 bg-white py-9 px-8 shadow-md border-b border-gray-100">
        <h1 class="text-3xl font-bold text-black">Track Record</h1>
    </div>


    <div class="p-8 lg:p-10">
        {{-- HEADER: Judul & Filter --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-5 gap-4"> 
            <div class="mb-6 flex items-center gap-2">
                <h2 class="text-xl font-bold text-[#0099FF]">Recently Added</h2>
                <i class="fas fa-chevron-right text-[#0099FF] text-sm"></i>
            </div>

            {{-- Kanan: Filter Tahun & Add Button --}}
            <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                {{-- Form Filter (Otomatis submit saat ganti tahun) --}}
                <form action="{{ route('admin.travel-records.index') }}" method="GET">
                    <div class="relative">
                        <select name="year" onchange="this.form.submit()" class="appearance-none bg-white border border-gray-200 text-black font-bold py-2.5 pl-6 pr-10 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition focus:outline-none min-w-37.5">
                            <option value="">All Years</option>
                            @for ($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-black">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </form>

                {{-- Tombol Add New (Shortcut) --}}
                <a href="{{ route('admin.travel-records.create') }}" class="bg-[#0099FF] text-white w-10 h-10 rounded-full flex items-center justify-center shadow-md hover:bg-blue-700 transition" title="Add New">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>


        {{-- PESAN SUKSES (Muncul setelah create/delete) --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="text-green-700 font-bold">x</button>
            </div>
        @endif

        {{-- GRID KARTU (CARD) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            
            @forelse($travelRecords as $record)
                {{-- CARD ITEM --}}
                <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col h-full group">
                    
                    {{-- Banner Image --}}
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ Storage::url($record->banner_image) }}" alt="{{ $record->city_name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        {{-- Badge Tahun --}}
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-800 shadow-sm">
                            {{ $record->year }}
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="text-lg font-bold text-black mb-2">{{ $record->city_name }}</h3>
                        <p class="text-gray-500 text-xs leading-relaxed mb-4 line-clamp-3 flex-1">
                            {{ $record->description }}
                        </p>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-2 mt-auto">
                            {{-- View More --}}
                            <a href="{{ route('track-record.show', $record->slug) }}" class="bg-[#1F2937] text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-black transition flex-1 text-center">
                                View More
                            </a>
                            
                            {{-- Edit --}}
                            <a href="{{ route('admin.travel-records.edit', $record->id) }}" class="bg-[#0099FF] text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-600 transition">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.travel-records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#FF0000] text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-red-600 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan Kosong --}}
                <div class="col-span-full py-20 text-center text-gray-400 flex flex-col items-center">
                    <i class="fas fa-folder-open text-6xl mb-4 text-gray-200"></i>
                    <p class="text-lg font-medium">Belum ada Track Record.</p>
                    <a href="{{ route('admin.travel-records.create') }}" class="mt-4 text-[#0099FF] hover:underline font-bold">
                        + Buat Baru Sekarang
                    </a>
                </div>
            @endforelse

        </div>

    </div>
</x-admin-layout>