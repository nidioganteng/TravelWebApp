<x-admin-layout>
    {{-- JUDUL HALAMAN --}}
    <div class="flex items-center gap-4 bg-white py-9 px-8 shadow-md border-b border-gray-100">
        <a href="{{ route('admin.travel-records.index') }}" class="text-[#0099FF] hover:text-blue-500 transition">
            <i class="fas fa-arrow-left text-2xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-[#0099FF]"><a href="{{ route('admin.travel-records.index') }}">Edit Track Record</a></h1>
    </div>

    {{-- FORM EDIT (x-data diisi data dari DB) --}}
    <form x-data="{ items: {{ $travelRecord->items }} }" id="trackRecordForm" action="{{ route('admin.travel-records.update', $travelRecord->id) }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-12">
        @csrf
        @method('PUT') {{-- Wajib untuk Update --}}

        {{-- BAGIAN ATAS --}}
        <div class="flex flex-col lg:flex-row gap-8 items-start mb-8">
            
            {{-- KARTU MAIN INFO --}}
            <div class="w-full lg:flex-1 bg-white rounded-[20px] p-8 shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                    
                    {{-- Input --}}
                    <div class="md:col-span-5 flex flex-col gap-5">
                        <div>
                            <label class="block text-sm font-bold text-black mb-2">City</label>
                            <input type="text" name="city_name" value="{{ old('city_name', $travelRecord->city_name) }}" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-black mb-2">Description</label>
                            <textarea name="description" rows="4" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition resize-none h-32" required>{{ old('description', $travelRecord->description) }}</textarea>
                        </div>
                    </div>

                    {{-- Upload Banner --}}
                    <div class="md:col-span-7 h-full">
                        <div class="relative w-full h-full min-h-50 border-[2.5px] border-dashed border-black rounded-xl flex flex-col items-center justify-center text-center cursor-pointer hover:bg-blue-50 transition group overflow-hidden">
                            <input type="file" name="banner_image" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer" accept="image/*" onchange="handlePreview(this)">
                            
                            {{-- UI Default (Hidden if image exists) --}}
                            <div class="flex flex-col items-center justify-center z-10 pointer-events-none px-4 transition-opacity duration-300 upload-ui {{ $travelRecord->banner_image ? 'opacity-0' : '' }}">
                                <div class="bg-[#0099FF] text-white w-40 py-2.5 rounded-lg font-bold text-lg shadow-md flex items-center justify-center gap-2 mb-3">
                                    <i class="fas fa-upload"></i> Change Banner
                                </div>
                                <p class="text-xs font-bold text-black">Click to replace current banner.</p>
                            </div>
                            
                            {{-- Preview Image (Load from DB) --}}
                            <img src="{{ Storage::url($travelRecord->banner_image) }}" class="absolute inset-0 w-full h-full object-cover z-10 preview-img {{ $travelRecord->banner_image ? '' : 'hidden' }}">
                        </div>
                    </div>

                </div>
            </div>

            {{-- SIDEBAR ACTION --}}
            <div class="w-full lg:w-64 flex flex-col gap-4 shrink-0">
                <div class="relative w-full">
                    <select name="year" class="w-full appearance-none bg-white border border-gray-200 text-black font-bold py-3 pl-6 pr-10 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition focus:outline-none">
                        @for ($i = date('Y'); $i >= 2010; $i--)
                            <option value="{{ $i }}" {{ $travelRecord->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-black">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#27AE60] text-white py-3 rounded-full font-bold shadow-md hover:bg-green-700 transition text-center text-lg">
                    Update Changes
                </button>

                <a href="{{ route('admin.travel-records.index') }}" class="w-full bg-[#D12020] text-white py-3 rounded-full font-bold shadow-md hover:bg-red-700 transition text-center text-lg">
                    Cancel
                </a>
            </div>
        </div> 

        {{-- TOMBOL ADD --}}
        <div class="flex justify-end mb-6">
            <button type="button" @click="items.push({id: Date.now(), title: '', description: '', image_url: ''})" class="bg-[#0099FF] text-white px-5 py-2 rounded-lg font-bold text-sm shadow-md hover:bg-blue-600 transition flex items-center gap-2">
                Add Description <i class="fas fa-plus"></i>
            </button>
        </div>

        {{-- REPEATER (EDIT MODE) --}}
        <div class="flex flex-col gap-8">
            <template x-for="(item, index) in items" :key="item.id">
                
                <div class="bg-white rounded-[20px] p-8 shadow-sm border border-gray-100 relative group w-full">
                    
                    <button type="button" @click="items = items.filter(i => i.id !== item.id)" x-show="items.length > 1" class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition z-20 text-xl">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                        
                        {{-- Logic Zig-Zag --}}
                        <div class="md:col-span-5 flex flex-col gap-5" :class="index % 2 !== 0 ? 'md:order-last' : ''">
                            <div>
                                <label class="block text-sm font-bold text-black mb-2">Title</label>
                                <input type="text" :name="'items['+index+'][title]'" x-model="item.title" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-black mb-2">Description</label>
                                <textarea :name="'items['+index+'][description]'" x-model="item.description" rows="4" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition resize-none h-40" required></textarea>
                            </div>
                        </div>

                        {{-- Upload Repeater --}}
                        <div class="md:col-span-7 h-full">
                            <div class="relative w-full h-full min-h-62.5 border-[2.5px] border-dashed border-black rounded-xl flex flex-col items-center justify-center text-center cursor-pointer hover:bg-blue-50 transition group overflow-hidden">
                                
                                {{-- INPUT FILE BARU --}}
                                <input type="file" :name="'items['+index+'][image]'" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer" accept="image/*" onchange="handlePreview(this)">
                                
                                {{-- HIDDEN INPUT: SIMPAN PATH GAMBAR LAMA --}}
                                <input type="hidden" :name="'items['+index+'][old_image]'" :value="item.image">

                                {{-- UI Upload --}}
                                <div class="flex flex-col items-center justify-center z-10 pointer-events-none px-4 transition-opacity duration-300 upload-ui" :class="item.image_url ? 'opacity-0' : ''">
                                    <div class="bg-[#0099FF] text-white w-40 py-2.5 rounded-lg font-bold text-lg shadow-md flex items-center justify-center gap-2 mb-3">
                                        <i class="fas fa-upload"></i> Upload
                                    </div>
                                    <p class="text-xs font-bold text-black">Choose images or drag & drop it here.</p>
                                </div>
                                
                                {{-- Preview Image --}}
                                <img :src="item.image_url" class="absolute inset-0 w-full h-full object-cover z-10 preview-img" :class="item.image_url ? '' : 'hidden'">
                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </form>

    <script>
        function handlePreview(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                const parent = input.closest('div.relative'); 
                if (parent) {
                    const img = parent.querySelector('.preview-img');
                    const ui = parent.querySelector('.upload-ui');
                    reader.onload = (e) => {
                        if (img) { img.src = e.target.result; img.classList.remove('hidden'); }
                        if (ui) { ui.classList.add('opacity-0'); }
                    }
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</x-admin-layout>