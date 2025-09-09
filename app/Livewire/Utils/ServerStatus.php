<?php

namespace App\Livewire\Utils;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ServerStatus extends Component
{
    /**
     * Collected server/application status data.
     *
     * @var array<string, mixed>
     */
    public array $status = [];

    public function mount(): void
    {
        $this->status = $this->gatherStatus();
    }

    /**
     * Collect various server and app health metrics.
     *
     * @return array<string, mixed>
     */
    private function gatherStatus(): array
    {
        $result = [];

        $requiredExtensions = [
            'openssl', 'pdo', 'mbstring', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath'
        ];

        $result['app_env'] = Config::get('app.env');
        $result['app_debug'] = (bool) Config::get('app.debug');
        $result['php_version'] = PHP_VERSION;
        $result['php_extensions'] = $requiredExtensions;
        $result['extensions_ok'] = collect($requiredExtensions)
            ->every(static fn (string $ext): bool => extension_loaded($ext));

        $directoriesToCheck = [
            'storage',
            'storage/framework',
            'storage/logs',
            'bootstrap/cache',
        ];
        $writable = [];
        foreach ($directoriesToCheck as $relativePath) {
            $writable[$relativePath] = is_writable(base_path($relativePath));
        }
        $result['writable'] = $writable;

        try {
            DB::connection()->getPdo();
            $result['database'] = 'ok (' . Config::get('database.default') . ')';
        } catch (\Throwable $e) {
            $result['database'] = 'error: ' . $e->getMessage();
        }

        try {
            Cache::put('healthcheck', 'ok', 5);
            $ok = Cache::get('healthcheck') === 'ok';
            $result['cache'] = $ok ? 'ok (' . Config::get('cache.default') . ')' : 'error';
        } catch (\Throwable $e) {
            $result['cache'] = 'error: ' . $e->getMessage();
        }

        $result['storage_disk_default'] = Config::get('filesystems.default');
        try {
            $result['storage_disk_root_exists'] = Storage::exists('/');
        } catch (\Throwable $e) {
            $result['storage_disk_root_exists'] = false;
        }

        $result['storage_link_exists'] = is_link(public_path('storage')) || file_exists(public_path('storage'));

        $result['disk_free'] = @disk_free_space('/') ?: null;
        $result['disk_total'] = @disk_total_space('/') ?: null;

        $result['opcache_enabled'] = function_exists('opcache_get_status')
            ? (bool) (opcache_get_status(false)['opcache_enabled'] ?? false)
            : false;

        // pastikan timezone mengikuti konfigurasi app
        $result['server_time'] = now()->setTimezone(config('app.timezone'))->toDateTimeString();

        // Memory usage (application, peak, PHP limit, and optional system memory)
        $result['memory'] = $this->getMemoryUsage();

        return $result;
    }

    /**
     * Get memory usage details for the application and system when possible.
     *
     * @return array<string, mixed>
     */
    private function getMemoryUsage(): array
    {
        $appUsage = (int) memory_get_usage(true);
        $appPeak = (int) memory_get_peak_usage(true);

        $memoryLimitRaw = (string) ini_get('memory_limit');
        $memoryLimitBytes = $this->convertIniToBytes($memoryLimitRaw);

        $systemTotal = null;
        $systemFree = null;
        try {
            if (is_readable('/proc/meminfo')) {
                $meminfo = file('/proc/meminfo');
                $data = [];
                foreach ($meminfo as $line) {
                    [$key, $value] = array_map('trim', explode(':', $line, 2));
                    $data[$key] = $value;
                }
                // Values are typically in kB
                if (isset($data['MemTotal'])) {
                    $systemTotal = (int) filter_var($data['MemTotal'], FILTER_SANITIZE_NUMBER_INT) * 1024;
                }
                if (isset($data['MemAvailable'])) {
                    $systemFree = (int) filter_var($data['MemAvailable'], FILTER_SANITIZE_NUMBER_INT) * 1024;
                } elseif (isset($data['MemFree'])) {
                    $systemFree = (int) filter_var($data['MemFree'], FILTER_SANITIZE_NUMBER_INT) * 1024;
                }
            }
        } catch (\Throwable $e) {
            $systemTotal = null;
            $systemFree = null;
        }

        $usagePercentOfLimit = null;
        if ($memoryLimitBytes !== null && $memoryLimitBytes > 0) {
            $usagePercentOfLimit = round(($appUsage / $memoryLimitBytes) * 100);
        }

        return [
            'app_usage' => $appUsage,
            'app_peak' => $appPeak,
            'php_memory_limit_raw' => $memoryLimitRaw,
            'php_memory_limit_bytes' => $memoryLimitBytes,
            'app_usage_percent_of_limit' => $usagePercentOfLimit,
            'system_total' => $systemTotal,
            'system_free' => $systemFree,
        ];
    }

    /**
     * Convert php.ini shorthand (e.g., 128M) to bytes. Returns null on failure.
     */
    private function convertIniToBytes(string $val): ?int
    {
        $trimmed = trim($val);
        if ($trimmed === '' || $trimmed === '-1') {
            return null; // unlimited or unknown
        }
        $last = strtolower(substr($trimmed, -1));
        $num = $trimmed;
        $multiplier = 1;
        if (in_array($last, ['g', 'm', 'k'], true)) {
            $num = substr($trimmed, 0, -1);
            if ($last === 'g') { $multiplier = 1024 ** 3; }
            if ($last === 'm') { $multiplier = 1024 ** 2; }
            if ($last === 'k') { $multiplier = 1024; }
        }
        if (!is_numeric($num)) {
            return null;
        }
        return (int) ((float) $num * $multiplier);
    }

    public function render()
    {
        // Refresh status on each render so UI can poll for realtime updates
        $this->status = $this->gatherStatus();
        return view('livewire.utils.server-status', [
            'status' => $this->status,
        ]);
    }
}


