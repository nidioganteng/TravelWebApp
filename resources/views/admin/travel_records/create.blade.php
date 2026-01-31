<x-admin-layout>
    {{-- JUDUL HALAMAN --}}
    <div class="flex items-center gap-4 bg-white py-9 px-8 shadow-md border-b border-gray-100">
        <a href="{{ route('admin.travel-records.index') }}" class="text-[#0099FF] hover:text-blue-500 transition">
            <i class="fas fa-arrow-left text-2xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-[#0099FF]"><a href="{{ route('admin.travel-records.index') }}">New Track Record</a></h1>
    </div>

    {{-- PESAN ERROR VALIDASI --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong class="font-bold">Ada yang salah!</strong>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- FORM WRAPPER (x-data dipindah kesini agar mencakup seluruh halaman) --}}
    <form x-data="{ items: [{id: Date.now()}] }" id="trackRecordForm" action="{{ route('admin.travel-records.store') }}" method="POST" enctype="multipart/form-data" class="p-8 lg:p-12">
        @csrf

        {{-- ================= BAGIAN ATAS (SPLIT KOLOM) ================= --}}
        {{-- Kiri: Kartu Utama, Kanan: Tombol Action --}}
        <div class="flex flex-col lg:flex-row gap-8 items-start mb-8">
            
            {{-- 1. KARTU MAIN INFORMATION (KIRI) --}}
            <div class="w-full lg:flex-1 bg-white rounded-[20px] p-8 shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                    
                    {{-- Input --}}
                    <div class="md:col-span-5 flex flex-col gap-5">
                        <div>
                            <label class="block text-sm font-bold text-black mb-2">City</label>
                            <input type="text" name="city_name" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition placeholder-gray-400" placeholder="City name...." required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-black mb-2">Description</label>
                            {{-- GANTI DIV JADI TEXTAREA --}}
                            <textarea name="description" rows="4" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition placeholder-gray-400 resize-none h-32" placeholder="Write the main description here..." required></textarea>
                        </div>
                    </div>

                    {{-- Upload Banner --}}
                    <div class="md:col-span-7 h-full">
                        <div class="relative w-full h-full min-h-50 border-[2.5px] border-dashed border-black rounded-xl flex flex-col items-center justify-center text-center cursor-pointer hover:bg-blue-50 transition group overflow-hidden">
                            <input type="file" name="banner_image" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer" accept="image/*" onchange="handlePreview(this)">
                            
                            <div class="flex flex-col items-center justify-center z-10 pointer-events-none px-4 transition-opacity duration-300 upload-ui">
                                <div class="bg-[#0099FF] text-white w-40 py-2.5 rounded-lg font-bold text-lg shadow-md flex items-center justify-center gap-2 mb-3">
                                    <i class="fas fa-upload"></i> Upload
                                </div>
                                <p class="text-xs font-bold text-black">Choose images or drag & drop it here.</p>
                                <p class="text-[10px] text-black font-bold mt-1">SVG. Max 10 MB.</p>
                            </div>
                            
                            <img class="absolute inset-0 w-full h-full object-cover z-10 hidden preview-img">
                        </div>
                    </div>

                </div>
            </div>

            {{-- 2. SIDEBAR ACTION (KANAN) --}}
            <div class="w-full lg:w-64 flex flex-col gap-4 shrink-0">
                {{-- Select Year --}}
                <div class="relative w-full">
                    <select name="year" class="w-full appearance-none bg-white border border-gray-200 text-black font-bold py-3 pl-6 pr-10 rounded-full shadow-md cursor-pointer hover:bg-gray-50 transition focus:outline-none" required>
                        {{-- Opsi Default (Placeholder) --}}
                        <option value="" disabled selected>Select year</option>
                        
                        {{-- Loop Tahun (Dari Sekarang sampai 2020) --}}
                        @for ($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    
                    {{-- Icon Panah --}}
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-black">
                        <i class="fas fa-chevron-down text-sm"></i>
                    </div>
                </div>

                {{-- Publish --}}
                <button type="submit" class="w-full bg-[#27AE60] text-white py-3 rounded-full font-bold shadow-md hover:bg-green-700 transition text-center text-lg">
                    Publish
                </button>

                {{-- Discard --}}
                <button type="button" onclick="window.location.reload()" class="w-full bg-[#D12020] text-white py-3 rounded-full font-bold shadow-md hover:bg-red-700 transition text-center text-lg">
                    Discard
                </button>
            </div>

        </div> 
        {{-- END BAGIAN ATAS --}}


        {{-- ================= BAGIAN TENGAH (TOMBOL ADD) ================= --}}
        <div class="flex justify-end mb-6">
            <button type="button" @click="items.push({id: Date.now()})" class="bg-[#0099FF] text-white px-5 py-2 rounded-lg font-bold text-sm shadow-md hover:bg-blue-600 transition flex items-center gap-2">
                Add Description <i class="fas fa-plus"></i>
            </button>
        </div>


        {{-- ================= BAGIAN BAWAH (REPEATER FULL WIDTH) ================= --}}
        {{-- Sekarang dia ada di luar flex container atas, jadi bebas melebar 100% --}}
        <div class="flex flex-col gap-8">
            <template x-for="(item, index) in items" :key="item.id">
                
                <div class="bg-white rounded-[20px] p-8 shadow-sm border border-gray-100 relative group w-full">
                    
                    {{-- Tombol Hapus --}}
                    <button type="button" @click="items = items.filter(i => i.id !== item.id)" x-show="items.length > 1" class="absolute top-4 right-4 text-gray-300 hover:text-red-500 transition z-20 text-xl">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                        
                        {{-- ZIG-ZAG LOGIC --}}
                        {{-- Jika Genap (0,2..): Input Kiri. Jika Ganjil (1,3..): Input Kanan (order-last) --}}
                        <div class="md:col-span-5 flex flex-col gap-5" :class="index % 2 !== 0 ? 'md:order-last' : ''">
                            <div>
                                <label class="block text-sm font-bold text-black mb-2">Title</label>
                                <input type="text" :name="'items['+index+'][title]'" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition placeholder-gray-400" placeholder="title...." required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-black mb-2">Description</label>
                                <textarea :name="'items['+index+'][description]'" rows="4" class="w-full border border-gray-400 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:border-[#0099FF] transition placeholder-gray-400 resize-none h-40" placeholder="Your Text Here" required></textarea>
                            </div>
                        </div>

                        {{-- UPLOAD --}}
                        <div class="md:col-span-7 h-full">
                            <div class="relative w-full h-full min-h-62.5 border-[2.5px] border-dashed border-black rounded-xl flex flex-col items-center justify-center text-center cursor-pointer hover:bg-blue-50 transition group overflow-hidden">
                                <input type="file" :name="'items['+index+'][image]'" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer" accept="image/*" onchange="handlePreview(this)">
                                
                                <div class="flex flex-col items-center justify-center z-10 pointer-events-none px-4 transition-opacity duration-300 upload-ui">
                                    <div class="bg-[#0099FF] text-white w-40 py-2.5 rounded-lg font-bold text-lg shadow-md flex items-center justify-center gap-2 mb-3">
                                        <i class="fas fa-upload"></i> Upload
                                    </div>
                                    <p class="text-xs font-bold text-black">Choose images or drag & drop it here.</p>
                                    <p class="text-[10px] text-black font-bold mt-1">SVG. Max 10 MB.</p>
                                </div>
                                
                                <img class="absolute inset-0 w-full h-full object-cover z-10 hidden preview-img">
                            </div>
                        </div>

                    </div>
                </div>
            </template>
        </div>
    </form>

    {{-- SCRIPTS LOGIC PREVIEW --}}
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
                        if (img) {
                            img.src = e.target.result;
                            img.classList.remove('hidden');
                        }
                        if (ui) {
                            ui.classList.add('opacity-0');
                        }
                    }
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</x-admin-layout>