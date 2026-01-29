<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('MijnAmor.svg') }}" type="image/svg">
    <title>Mijn Amor Travel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="w-72 bg-[#0099FF] text-white flex flex-col fixed h-full shadow-xl z-50">
            <div class="flex justify-center items-center p-8 w-full">
                <img src="/img/login/icon/MijnIconWhite.svg" alt="Mijn Amor Logo">
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-3 rounded-full transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#0099FF] shadow-lg' : 'hover:bg-white/10' }}">
                    <i class="fas fa-home w-6 mr-4"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <div x-data="{ open: {{ request()->is('admin/manage-product*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center px-6 py-3 rounded-full transition-all {{ request()->routeIs('admin/manage-product') ? 'bg-white text-[#0099FF] shadow-lg' : 'hover:bg-white/10' }}">
                        <i class="fas fa-box w-6 mr-4"></i>
                        <span class="font-medium flex-1 text-left">Manage Product</span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" class="ml-12 mt-2 border-l-2 border-white/50 space-y-2 pb-2">
                        <a href="/admin/manage-product/add" class="relative flex items-center pl-6 py-2 text-sm hover:text-white/80">
                            <span class="absolute left-0 w-4 border-t-2 border-white/50"></span>
                            <span class="{{ request()->is('admin/manage-product/add') ? 'border-b-2 border-white' : '' }}">Add Product</span>
                        </a>
                        <a href="/admin/manage-product/list" class="relative flex items-center pl-6 py-2 text-sm hover:text-white/80">
                            <span class="absolute left-0 w-4 border-t-2 border-white/50"></span>
                            <span class="{{ request()->is('admin/manage-product/list') ? 'border-b-2 border-white' : '' }}">Product List</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ open: {{ request()->is('admin/track-record*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center px-6 py-3 rounded-full transition-all {{ request()->is('admin/track-record*') ? 'bg-white text-[#0099FF]' : 'hover:bg-white/10' }}">
                        <i class="fas fa-list-check w-6 mr-4"></i>
                        <span class="font-medium flex-1 text-left">Track Record</span>
                        <i class="fas fa-chevron-down text-xs transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" class="ml-12 mt-2 border-l-2 border-white/50 space-y-2 pb-2">
                        <a href="/admin/track-record/add" class="relative flex items-center pl-6 py-2 text-sm hover:text-white/80">
                            <span class="absolute left-0 w-4 border-t-2 border-white/50"></span>
                            <span class="{{ request()->is('admin/track-record/add') ? 'border-b-2 border-white' : '' }}">Add Track Record</span>
                        </a>
                        <a href="/admin/track-record/list" class="relative flex items-center pl-6 py-2 text-sm hover:text-white/80">
                            <span class="absolute left-0 w-4 border-t-2 border-white/50"></span>
                            <span class="{{ request()->is('admin/track-record/list') ? 'border-b-2 border-white' : '' }}">Track Records</span>
                        </a>
                    </div>
                </div>

                <div x-data="{ open: {{ request()->is('admin/booking-list*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center px-6 py-3 rounded-full transition-all {{ request()->routeIs('admin/booking-list') ? 'bg-white text-[#0099FF] shadow-lg' : 'hover:bg-white/10' }}">
                        <i class="fas fa-book w-6 mr-4"></i>
                        <span class="font-medium">Booking List</span>
                    </button>
                </div>

                {{-- Messages (Langsung Link, Hapus x-data) --}}
                <a href="{{ route('admin.messages.index') }}" 
                class="w-full flex items-center px-6 py-3 rounded-full transition-all {{ request()->routeIs('admin.messages*') ? 'bg-white text-[#0099FF] shadow-lg' : 'hover:bg-white/10' }}">
                    <i class="fas fa-envelope w-6 mr-4"></i>
                    <span class="font-medium">Messages</span>
                </a>

                <div x-data="{ open: {{ request()->is('admin/settings*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center px-6 py-3 rounded-full transition-all {{ request()->routeIs('admin/settings') ? 'bg-white text-[#0099FF] shadow-lg' : 'hover:bg-white/10' }}">
                        <i class="fas fa-cog w-6 mr-4"></i>
                        <span class="font-medium">Settings</span>
                    </button>
                </div>
            </nav>

            <div class="mt-auto border-t border-white/20 p-4 bg-[#0066FF]">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-white text-[#0099FF] flex items-center justify-center font-bold text-xl">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <div class="font-bold truncate text-sm">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-blue-100 opacity-80 tracking-widest">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 ml-72 bg-gray-50 min-h-screen">
            {{ $slot }}
        </main>
    </div>
</body>

</html>