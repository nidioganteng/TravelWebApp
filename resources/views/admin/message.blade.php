<x-admin-layout>
    <div class="bg-white py-9 px-8 shadow-md border-b border-gray-100 mb-8">
        <h1 class="text-3xl font-bold text-black tracking-tight">Messages</h1>
    </div>

    <div class="px-8 pb-8">
    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- CONTAINER UTAMA --}}
    {{-- Kita pakai flex container untuk menampung Kiri dan Kanan --}}
    <div x-data="{ selected: null }" class="flex gap-6 relative items-start">

        {{-- ========================================== --}}
        {{-- BAGIAN KIRI: DAFTAR PESAN (LIST) --}}
        {{-- ========================================== --}}
        {{-- Logic: Jika selected ada isinya, lebar 7/12. Jika kosong, lebar full (w-full) --}}
        {{-- BAGIAN KIRI: DAFTAR PESAN (SATU KOTAK UTUH) --}}
        <div class="bg-white rounded-[20px] shadow-md border border-gray-100 flex flex-col transition-all duration-500 ease-in-out overflow-hidden"
            :class="selected ? 'w-full lg:w-7/12' : 'w-full'">
            
            {{-- 1. HEADER KOLOM --}}
            {{-- Grid dibagi rata: 3 - 3 - 3 - 3 --}}
            <div class="grid grid-cols-12 px-6 py-4 border-b border-gray-100 bg-[#EEF8FF] text-gray-400 font-medium text-sm">
                <div class="col-span-3">From</div>
                <div class="col-span-3">Email</div>
                <div class="col-span-3">Received At</div>
                <div class="col-span-3">Action</div>
            </div>

            {{-- 2. LIST PESAN --}}
            <div class="flex flex-col">
                @forelse($messages as $msg)
                    <div class="grid grid-cols-12 items-center px-6 py-5 border-b border-gray-50 hover:bg-blue-50/30 transition last:border-0">
                        
                        {{-- KOLOM 1: NAMA (Tanggal di bawah nama DIHAPUS, karena sudah pindah) --}}
                        <div class="col-span-3 overflow-hidden pr-2">
                            <h3 class="font-medium text-gray-800 text-base truncate">{{ $msg->name }}</h3>
                        </div>

                        {{-- KOLOM 2: EMAIL --}}
                        <div class="col-span-3 text-sm text-gray-600 truncate pr-2">
                            {{ $msg->email }}
                        </div>

                        {{-- KOLOM 3: WAKTU (REAL TIME) --}}
                        {{-- Format: 30 Jan 2026, 14:30 --}}
                        <div class="col-span-3 text-sm text-gray-500">
                            <span class="bg-gray-100 px-2 py-1 rounded-md text-xs font-medium">
                                {{ $msg->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>

                        {{-- KOLOM 4: ACTION --}}
                        <div class="col-span-3 flex gap-2">
                            {{-- View All --}}
                            <button @click="selected = {{ $msg }}" 
                                    class="bg-[#0099FF] text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-600 transition flex items-center gap-2 shadow-blue-200 shadow-md whitespace-nowrap">
                                View All <i class="fas fa-caret-right"></i>
                            </button>

                            {{-- Delete --}}
                            <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#FF4D4F] text-white px-3 py-2 rounded-lg text-xs hover:bg-red-600 transition shadow-red-200 shadow-md">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    {{-- Tampilan Kosong --}}
                    <div class="py-12 flex flex-col items-center justify-center text-center text-gray-400">
                        <i class="fas fa-inbox text-5xl mb-4 text-gray-200"></i>
                        <p class="text-sm">Belum ada pesan masuk.</p>
                    </div>
                @endforelse
            </div>
        </div>


        {{-- ========================================== --}}
        {{-- BAGIAN KANAN: DETAIL PESAN --}}
        {{-- ========================================== --}}
        {{-- Logic: Jika selected kosong, width 0 dan opacity 0 (hilang). Jika ada, width 5/12 (muncul) --}}
        <div class="sticky top-6 transition-all duration-500 ease-in-out overflow-hidden"
             :class="selected ? 'w-full lg:w-5/12 opacity-100 translate-x-0' : 'w-0 opacity-0 translate-x-20'">
            
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden w-full">
                
                {{-- HEADER DETAIL --}}
                <div class="bg-[#EEF8FF] p-6 border-b border-gray-200 flex justify-between items-start">
                    <div class="flex items-center gap-4 overflow-hidden">
                        {{-- Avatar Bulat --}}
                        <div class="w-12 h-12 rounded-full border border-gray-200 bg-white text-[#0099FF] shrink-0 flex items-center justify-center font-bold text-xl">
                            <span x-text="selected?.name?.substring(0,2).toUpperCase()"></span>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-gray-900 truncate" x-text="selected?.name"></h2>
                            <a :href="'mailto:' + selected?.email" class="text-sm text-[#0099FF] hover:underline truncate block" x-text="selected?.email"></a>
                        </div>
                    </div>

                    {{-- TOMBOL CLOSE (X) --}}
                    <button @click="selected = null" class="text-gray-400 hover:text-red-500 transition p-2">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                {{-- BODY DETAIL --}}
                <div class="p-6 bg-white">
                    <h3 class="font-bold text-gray-800 mb-2 text-sm">Message:</h3>
                    
                    {{-- Isi Pesan --}}
                    <div class="bg-gray-50 p-4 rounded-xl text-gray-600 text-sm leading-relaxed whitespace-pre-line border border-gray-100 min-h-37.5" 
                         x-text="selected?.message">
                    </div>

                    {{-- Footer Waktu --}}
                    <div class="mt-4 text-right">
                        <span class="text-xs text-gray-400">
                            Dikirim pada: <span x-text="new Date(selected?.created_at).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
</x-admin-layout>