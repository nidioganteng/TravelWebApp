<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Mijn Amor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-blue-500 text-white flex flex-col fixed h-full z-10">
            <div class="p-6 text-center text-2xl font-serif font-bold italic border-b border-blue-400">
                Mijn Amor
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-white text-blue-600 font-bold' : 'hover:bg-blue-600' }}">
                    <i class="fas fa-home w-6"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.products.*') ? 'bg-white text-blue-600 font-bold' : 'hover:bg-blue-600' }}">
                    <i class="fas fa-box w-6"></i>
                    <span>Manage Product</span>
                </a>

                <a href="{{ route('admin.travel-records.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.travel-records.*') ? 'bg-white text-blue-600 font-bold' : 'hover:bg-blue-600' }}">
                    <i class="fas fa-list-check w-6"></i>
                    <span>Track Record</span>
                </a>

                <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.bookings.*') ? 'bg-white text-blue-600 font-bold' : 'hover:bg-blue-600' }}">
                    <i class="fas fa-book w-6"></i>
                    <span>Booking List</span>
                </a>

                <a href="{{ route('admin.messages.index') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.messages.*') ? 'bg-white text-blue-600 font-bold' : 'hover:bg-blue-600' }}">
                    <i class="fas fa-envelope w-6"></i>
                    <span>Messages</span>
                </a>
            </nav>

            <div class="p-4 border-t border-blue-400">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white text-blue-500 flex items-center justify-center font-bold">
                        A
                    </div>
                    <div>
                        <div class="font-bold text-sm">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-blue-100">Administrator</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="text-xs text-red-200 hover:text-white underline">Logout</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-64 p-8">
            {{ $slot }}
        </main>

    </div>

</body>

</html>