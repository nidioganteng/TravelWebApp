<x-admin-layout>
    <div class="bg-white py-9 px-8 shadow-md border-b border-gray-100 mb-8">
        <h1 class="text-3xl font-bold text-black tracking-tight">Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        <div class="bg-blue-600 text-white rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold opacity-80">Total Booking</h3>
            <div class="text-4xl font-bold mt-2">{{ $total_bookings }}</div>
            <div class="mt-4 text-sm opacity-75">Pesanan masuk</div>
        </div>

        <div class="bg-blue-500 text-white rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold opacity-80">Total Product</h3>
            <div class="text-4xl font-bold mt-2">{{ $total_products }}</div>
            <div class="mt-4 text-sm opacity-75">Paket tersedia</div>
        </div>

        <div class="bg-white text-gray-800 rounded-xl p-6 shadow-md border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-500">Total Users</h3>
            <div class="text-4xl font-bold mt-2 text-blue-600">{{ $total_users }}</div>
            <div class="mt-4 text-sm text-gray-400">Akun terdaftar</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="font-bold text-lg mb-4">Aktivitas Terbaru</h3>
        <p class="text-gray-500">Belum ada aktivitas baru.</p>
    </div>

</x-admin-layout>