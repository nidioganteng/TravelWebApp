<x-admin-layout> {{-- Sesuaikan dengan nama komponen layout kamu --}}
    <div class="p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Daftar Pengguna & Aktivitas</h2>
                <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-full text-xs font-bold">
                    Total: {{ $users->total() }} Users
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Terakhir Aktif</th>
                            <th class="px-6 py-4">Halaman Terakhir</th>
                            <th class="px-6 py-4">IP Address</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#0099FF] text-white flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($user->last_seen_at)
                                    {{ $user->last_seen_at->diffForHumans() }}
                                    <div class="text-[10px] text-gray-400">{{ $user->last_seen_at->format('d M Y, H:i') }}</div>
                                @else
                                    <span class="text-gray-400 italic">Belum terdeteksi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-xs bg-gray-100 px-2 py-1 rounded text-blue-600">
                                    /{{ $user->last_page ?? '-' }}
                                </code>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->last_ip ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->last_seen_at && $user->last_seen_at->diffInMinutes(now()) < 5)
                                    <span class="flex items-center gap-1.5 text-green-600 text-xs font-bold">
                                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Online
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs font-medium">Offline</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>