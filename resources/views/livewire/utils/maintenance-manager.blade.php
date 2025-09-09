<div class="max-w-6xl mx-auto p-6" wire:poll.2s>
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 shadow-modern-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Maintenance Manager</h1>
                <p class="opacity-90 text-sm mt-1">Atur halaman yang masuk mode maintenance dan pesan yang ditampilkan.</p>
            </div>
            <div class="hidden md:flex items-center space-x-2 opacity-90 text-sm">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-xs">{{ now()->toDayDateTimeString() }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="md:col-span-2 p-5 rounded-xl bg-white shadow-modern">
            <h2 class="font-semibold mb-3">Pilih Halaman (Named Routes)</h2>
            <div class="max-h-72 overflow-auto border rounded-lg">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-gray-700">Aktif</th>
                            <th class="px-3 py-2 text-left text-gray-700">Route Name</th>
                            <th class="px-3 py-2 text-left text-gray-700">URI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $r)
                            <tr class="border-t">
                                <td class="px-3 py-2 align-top">
                                    <input type="checkbox" value="{{ $r['name'] }}" wire:model="selectedRouteNames" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </td>
                                <td class="px-3 py-2 align-top font-mono text-gray-800">{{ $r['name'] }}</td>
                                <td class="px-3 py-2 align-top text-gray-600">{{ $r['uri'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-5 rounded-xl bg-white shadow-modern">
            <h2 class="font-semibold mb-3">Pesan Maintenance</h2>
            <textarea wire:model.defer="message" rows="6" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Tulis pesan singkat"></textarea>

            <h2 class="font-semibold mt-6 mb-2">Tambahan URI Patterns</h2>
            <p class="text-xs text-gray-500 mb-2">Gunakan pola seperti <code class="px-1 bg-gray-100 rounded text-gray-700">admin/*</code> atau <code class="px-1 bg-gray-100 rounded text-gray-700">reports/*</code></p>
            <div class="space-y-2">
                @foreach ($selectedUriPatterns as $idx => $pattern)
                    <div class="flex items-center space-x-2">
                        <input type="text" class="flex-1 rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm" wire:model="selectedUriPatterns.{{ $idx }}">
                        <button class="px-2 py-1 text-xs rounded bg-red-50 text-red-600 hover:bg-red-100" wire:click="selectedUriPatterns.splice({{ $idx }}, 1)">Hapus</button>
                    </div>
                @endforeach
                <button class="mt-2 text-xs px-3 py-1 rounded bg-gray-100 hover:bg-gray-200" wire:click="$set('selectedUriPatterns', [...(selectedUriPatterns||[]), ''])">+ Tambah Pattern</button>
            </div>

            <div class="mt-6 flex items-center space-x-3">
                <button wire:click="save" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
                <button wire:click="clear" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">Bersihkan</button>
                <a href="{{ route('maintenance.page') }}" target="_blank" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Preview</a>
            </div>
        </div>
    </div>

    <div class="mt-6 p-5 rounded-xl bg-white shadow-modern">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold">Halaman dalam Maintenance</h2>
            <span class="text-xs px-2 py-0.5 rounded-full bg-blue-50 text-blue-700">Realtime</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Berdasarkan Route Names</h3>
                <div class="border rounded-lg overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-gray-700">Route Name</th>
                                <th class="px-3 py-2 text-left text-gray-700">URI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $active = collect($routes)->filter(fn($r) => in_array($r['name'], $selectedRouteNames ?? []));
                            @endphp
                            @forelse ($active as $r)
                                <tr class="border-t">
                                    <td class="px-3 py-2 font-mono text-gray-800">{{ $r['name'] }}</td>
                                    <td class="px-3 py-2 text-gray-600">{{ $r['uri'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-3 py-3 text-center text-gray-500">Tidak ada route yang di-maintenance</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Berdasarkan URI Patterns</h3>
                <div class="border rounded-lg overflow-hidden">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-gray-700">Pattern</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($selectedUriPatterns as $p)
                                @if($p !== '')
                                    <tr class="border-t">
                                        <td class="px-3 py-2 font-mono text-gray-800">{{ $p }}</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td class="px-3 py-3 text-center text-gray-500">Tidak ada pattern aktif</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


