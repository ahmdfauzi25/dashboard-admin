<div class="max-w-6xl mx-auto p-6" wire:poll.5s>
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 shadow-modern-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Session History</h1>
                <p class="opacity-90 text-sm mt-1">Riwayat login dan logout pengguna.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-modern p-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
            <div class="flex items-center gap-2">
                <input type="text" wire:model.debounce.400ms="search" placeholder="Cari nama atau email..." class="block w-64 px-3 py-2 border border-gray-200 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                <select wire:model="event" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    <option value="">Semua event</option>
                    <option value="login">Login</option>
                    <option value="logout">Logout</option>
                </select>
            </div>
            <div class="text-xs text-gray-500">
                Auto refresh 5s
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Agent</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($activities as $a)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ \Carbon\Carbon::parse($a->created_at)->format('Y-m-d H:i:s') }}</td>
                            <td class="px-4 py-2 text-sm">
                                <div class="flex items-center">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold flex items-center justify-center mr-2">{{ strtoupper(substr($a->user->name ?? '?', 0, 2)) }}</div>
                                    <div>
                                        <div class="text-gray-900">{{ $a->user->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-gray-500">{{ $a->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <span class="px-2 py-1 rounded text-xs {{ $a->event === 'login' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ ucfirst($a->event) }}</span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $a->ip_address }}</td>
                            <td class="px-4 py-2 text-xs text-gray-500 max-w-[320px] truncate" title="{{ $a->user_agent }}">{{ $a->user_agent }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $activities->links() }}
        </div>
    </div>
</div>


