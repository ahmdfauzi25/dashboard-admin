<div class="max-w-6xl mx-auto p-6" wire:poll.1s>
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 shadow-modern-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Server Utilities</h1>
                <p class="opacity-90 text-sm mt-1">Status environment, permission, database, cache, dan disk.</p>
            </div>
            <div class="hidden md:flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-xs">Env: {{ strtoupper($status['app_env']) }}</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-xs">PHP {{ $status['php_version'] }}</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-xs">{{ $status['server_time'] }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="p-5 rounded-xl bg-white shadow-modern">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">Aplikasi</h2>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $status['app_debug'] ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">Debug {{ $status['app_debug'] ? 'ON' : 'OFF' }}</span>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Environment</span>
                    <span class="font-medium">{{ $status['app_env'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">PHP Version</span>
                    <span class="font-medium">{{ $status['php_version'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">Server Time</span>
                    <span class="font-medium">{{ $status['server_time'] }}</span>
                </div>
            </div>
        </div>

        {{-- KODE YANG DIMODIFIKASI DIMULAI DI SINI --}}
        <div class="p-5 rounded-xl bg-white shadow-modern">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">Database</h2>
                <span class="text-xs px-2 py-0.5 rounded-full {{ str_starts_with($status['database'], 'ok') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ str_starts_with($status['database'], 'ok') ? 'Healthy' : 'Error' }}</span>
            </div>

            {{-- PERUBAHAN 1: Mengganti tag <p> dengan div + flex untuk menampilkan ikon bulat --}}
            <div class="text-sm text-gray-700 flex items-center min-h-[1.25rem]">
                @if(str_starts_with($status['database'], 'ok'))
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 mr-2 shrink-0"></span>
                    {{-- Menghilangkan "ok" dan spasi di depannya dari string --}}
                    <span>{{ trim(substr($status['database'], 2)) }}</span>
                @else
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-red-500 mr-2 shrink-0"></span>
                    <span>{{ $status['database'] }}</span>
                @endif
            </div>

            <div class="mt-4 border-t pt-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">Cache</span>
                    {{-- PERUBAHAN 2: Mengganti konten span untuk cache dengan logika ikon bulat --}}
                    <span class="font-medium flex items-center {{ str_starts_with($status['cache'], 'ok') ? 'text-green-600' : 'text-red-600' }}">
                         @if(str_starts_with($status['cache'], 'ok'))
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 mr-2 shrink-0"></span>
                            <span>{{ trim(substr($status['cache'], 2)) }}</span>
                        @else
                            <span class="inline-block w-2.5 h-2.5 rounded-full bg-red-500 mr-2 shrink-0"></span>
                            <span>{{ $status['cache'] }}</span>
                        @endif
                    </span>
                </div>
                <div class="flex items-center justify-between text-sm mt-2">
                    <span class="text-gray-600">Storage Disk</span>
                    <span class="font-medium">{{ $status['storage_disk_default'] }}</span>
                </div>
                <div class="flex items-center justify-between text-sm mt-2">
                    <span class="text-gray-600">Disk Root Exists</span>
                    <span class="font-medium {{ $status['storage_disk_root_exists'] ? 'text-green-600' : 'text-red-600' }}">{{ $status['storage_disk_root_exists'] ? 'yes' : 'no' }}</span>
                </div>
            </div>
        </div>
        {{-- KODE YANG DIMODIFIKASI BERAKHIR DI SINI --}}

        <div class="p-5 rounded-xl bg-white shadow-modern">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">Ekstensi & OPcache</h2>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $status['opcache_enabled'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">OPcache {{ $status['opcache_enabled'] ? 'ON' : 'OFF' }}</span>
            </div>
            <div class="text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">PHP Extensions</span>
                    <span class="font-medium {{ $status['extensions_ok'] ? 'text-green-600' : 'text-red-600' }}">{{ $status['extensions_ok'] ? 'complete' : 'missing' }}</span>
                </div>
                <div class="mt-3 text-xs text-gray-500">Wajib: {{ implode(', ', $status['php_extensions']) }}</div>
            </div>
        </div>

        <div class="p-5 rounded-xl bg-white shadow-modern md:col-span-2 lg:col-span-3">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold">Memory</h2>
                @php
                    $p = $status['memory']['app_usage_percent_of_limit'];
                @endphp
                <span class="text-xs px-2 py-0.5 rounded-full {{ $p === null ? 'bg-gray-100 text-gray-700' : ($p < 70 ? 'bg-green-100 text-green-700' : ($p < 90 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">{{ $p === null ? 'unlimited' : ($p . '%') }}</span>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">App Usage</span>
                    <span class="font-medium">{{ number_format($status['memory']['app_usage'] / 1024 / 1024, 2) }} MB</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">App Peak</span>
                    <span class="font-medium">{{ number_format($status['memory']['app_peak'] / 1024 / 1024, 2) }} MB</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">PHP memory_limit</span>
                    <span class="font-medium">{{ $status['memory']['php_memory_limit_raw'] }}</span>
                </div>
            </div>
            @if(!empty($status['memory']['php_memory_limit_bytes']))
                @php
                    $memBarClass = $p === null
                        ? 'bg-gray-300'
                        : ($p < 70 ? 'bg-green-500' : ($p < 90 ? 'bg-yellow-500' : 'bg-red-500'));
                    $memWidth = min(100, (int) $status['memory']['app_usage_percent_of_limit']);
                @endphp
                <div class="mt-3 w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-2 {{ $memBarClass }}" style="width: {{ $memWidth }}%"></div>
                </div>
            @endif
            @if(!empty($status['memory']['system_total']))
                @php
                    $sysTotal = (float) $status['memory']['system_total'];
                    $sysFree = (float) ($status['memory']['system_free'] ?? 0);
                    $sysUsed = max(0, $sysTotal - $sysFree);
                    $sysPercent = $sysTotal > 0 ? round(($sysUsed / $sysTotal) * 100) : 0;
                    $sysBarClass = $sysPercent < 70 ? 'bg-green-500' : ($sysPercent < 90 ? 'bg-yellow-500' : 'bg-red-500');
                @endphp
                <div class="mt-4 border-t pt-3">
                    <div class="flex items-center justify-between text-sm mb-1">
                        <span class="text-gray-600">System</span>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $sysPercent < 70 ? 'bg-green-100 text-green-700' : ($sysPercent < 90 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">{{ $sysPercent }}%</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-2 {{ $sysBarClass }}" style="width: {{ $sysPercent }}%"></div>
                    </div>
                    <div class="mt-2 text-xs text-gray-600 flex items-center justify-between">
                        <span>Used: <strong>{{ number_format($sysUsed / 1024 / 1024, 2) }} MB</strong></span>
                        <span>Free: <strong>{{ number_format($sysFree / 1024 / 1024, 2) }} MB</strong></span>
                        <span>Total: <strong>{{ number_format($sysTotal / 1024 / 1024, 2) }} MB</strong></span>
                    </div>
                </div>
            @endif
        </div>

        <div class="p-5 rounded-xl bg-white shadow-modern md:col-span-2 lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold">Disk Usage</h2>
                <span class="text-xs text-gray-500">Public/storage: {{ $status['storage_link_exists'] ? 'linked' : 'missing' }}</span>
            </div>
            @php
                $free = (float) ($status['disk_free'] ?? 0);
                $total = (float) ($status['disk_total'] ?? 0);
                $used = $total > 0 ? max(0, $total - $free) : 0;
                $percent = $total > 0 ? round(($used / $total) * 100) : 0;
            @endphp
            @php
                $diskBarClass = $percent < 75 ? 'bg-green-500' : ($percent < 90 ? 'bg-yellow-500' : 'bg-red-500');
            @endphp
            <div class="w-full h-3 rounded-full bg-gray-100 overflow-hidden">
                <div class="h-3 {{ $diskBarClass }}" style="width: {{ $percent }}%"></div>
            </div>
            <div class="mt-2 text-sm text-gray-700 flex items-center justify-between">
                <span>Used: <strong>{{ $total ? number_format($used / 1024 / 1024, 2) . ' MB' : '-' }}</strong></span>
                <span>Free: <strong>{{ $total ? number_format($free / 1024 / 1024, 2) . ' MB' : '-' }}</strong></span>
                <span>Total: <strong>{{ $total ? number_format($total / 1024 / 1024, 2) . ' MB' : '-' }}</strong></span>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $percent < 75 ? 'bg-green-100 text-green-700' : ($percent < 90 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">{{ $percent }}%</span>
            </div>
        </div>

        <!-- Realtime Charts (Grafana-like) -->
        <div class="p-5 rounded-xl bg-white shadow-modern md:col-span-2 lg:col-span-3">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold">Realtime Charts</h2>
                <span class="text-xs text-gray-500">Auto refresh tiap detik</span>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-lg border border-gray-100 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Memory Usage %</span>
                        <span class="text-xs text-gray-500">Limit: {{ $status['memory']['php_memory_limit_raw'] }}</span>
                    </div>
                    <div class="h-48" wire:ignore>
                        <canvas id="chart-memory"></canvas>
                    </div>
                </div>
                <div class="rounded-lg border border-gray-100 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Disk Usage %</span>
                        <span class="text-xs text-gray-500">Root</span>
                    </div>
                    <div class="h-48" wire:ignore>
                        <canvas id="chart-disk"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-5 rounded-xl bg-white shadow-modern md:col-span-2 lg:col-span-3">
            <h2 class="font-semibold mb-3">Folder Permissions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach ($status['writable'] as $path => $ok)
                    <div class="flex items-center justify-between p-3 rounded-lg border {{ $ok ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                        <span class="text-sm font-mono">{{ $path }}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $ok ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $ok ? 'writable' : 'not writable' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Data push untuk grafik (dipanggil setiap render) -->
<script>
    window.dispatchEvent(new CustomEvent('server-stats', {
        detail: {
            t: Date.now(),
            memoryPercent: {{ (int) ($status['memory']['app_usage_percent_of_limit'] ?? 0) }},
            diskPercent: {{ (function () use ($status) { $free=(float)($status['disk_free']??0); $total=(float)($status['disk_total']??0); $used=$total>0?max(0,$total-$free):0; return $total>0? (int) round(($used/$total)*100):0; })() }}
        }
    }));
</script>

<!-- Inisialisasi Chart.js (sekali saja) -->
<script>
    (function initServerCharts(){
        if (window.__serverChartsInitialized) return;
        window.__serverChartsInitialized = true;

        function ensureChartJs(cb){
            if (window.Chart) { cb(); return; }
            const s = document.createElement('script');
            s.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js';
            s.onload = cb; document.head.appendChild(s);
        }

        ensureChartJs(function(){
            const memCtx = document.getElementById('chart-memory');
            const diskCtx = document.getElementById('chart-disk');

            const commonOptions = {
                responsive: true,
                animation: false,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: '#64748b' }, grid: { color: 'rgba(148,163,184,0.15)' } },
                    y: { min: 0, max: 100, ticks: { color: '#64748b', callback: v => v + '%' }, grid: { color: 'rgba(148,163,184,0.15)' } }
                }
            };

            const makeChart = (ctx, color) => new Chart(ctx, {
                type: 'line',
                data: { labels: [], datasets: [{ data: [], borderColor: color, backgroundColor: color + '33', fill: true, tension: 0.35, pointRadius: 0 }] },
                options: commonOptions
            });

            const charts = {
                mem: makeChart(memCtx, '#3b82f6'),
                disk: makeChart(diskCtx, '#22c55e')
            };

            const MAX_POINTS = 60; // ~60 detik histori

            function pushData(label, value, chart){
                const t = new Date(label).toLocaleTimeString();
                const ds = chart.data.datasets[0];
                chart.data.labels.push(t);
                ds.data.push(value);
                if (ds.data.length > MAX_POINTS) {
                    ds.data.shift();
                    chart.data.labels.shift();
                }
                chart.update('none');
            }

            window.addEventListener('server-stats', function(e){
                const d = e.detail || {};
                pushData(d.t, d.memoryPercent ?? 0, charts.mem);
                pushData(d.t, d.diskPercent ?? 0, charts.disk);
            });
        });
    })();
</script>
