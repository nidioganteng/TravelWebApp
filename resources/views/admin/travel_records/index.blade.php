<x-admin-layout>

    <div class="flex items-center gap-4 bg-white py-6 md:py-9 px-6 md:px-8 shadow-md border-b border-gray-100 sticky top-0 z-40 lg:relative">
        <h1 class="text-2xl md:text-3xl font-bold text-black">Track Record</h1>
    </div>


    <div class="p-5 md:p-8 lg:p-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4"> 
            <div class="flex items-center gap-2">
                <h2 class="text-lg md:text-xl font-bold text-[#0099FF]">Recently Added</h2>
                <i class="fas fa-chevron-right text-[#0099FF] text-xs"></i>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                <form action="{{ route('admin.travel-records.index') }}" method="GET" class="flex-1 md:flex-none">
                    <div class="relative w-full">
                        <select name="year" onchange="this.form.submit()" class="w-full appearance-none bg-white border border-gray-200 text-black font-bold py-2.5 pl-5 pr-10 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition focus:outline-none text-xs md:text-sm md:min-w-37.5">
                            <option value="">All Years</option>
                            @for ($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-black">
                            <i class="fas fa-chevron-down text-[10px] md:text-xs"></i>
                        </div>
                    </div>
                </form>

                <a href="{{ route('admin.travel-records.create') }}" class="bg-[#0099FF] text-white w-10 h-10 rounded-full flex items-center justify-center shadow-md hover:bg-blue-700 transition shrink-0" title="Add New">
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
                        <img src="{{ Storage::url($record->banner_image) }}" alt="{{ $record->city_name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
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
                                View
                            </a>

                            <a href="{{ route('admin.travel-records.edit', $record->id) }}" class="bg-[#0099FF] text-white px-3 py-2.5 rounded-xl text-[10px] font-bold hover:bg-blue-600 transition">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.travel-records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this data?');" class="shrink-0">
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
                    <p class="text-base md:text-lg font-medium text-gray-500">No Track Record Yet.</p>
                    <a href="{{ route('admin.travel-records.create') }}" class="mt-4 bg-[#0099FF] text-white px-6 py-2 rounded-full text-sm font-bold shadow-md hover:bg-blue-600 transition">
                        + Create New
                    </a>
                </div>
            @endforelse

        </div>

    </div>
</x-admin-layout>