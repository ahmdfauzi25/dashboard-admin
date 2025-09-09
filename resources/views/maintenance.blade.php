<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-purple-50/30 flex items-center justify-center p-6">
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-modern-lg p-8 text-center">
        <div class="mx-auto mb-6">
            <!-- Ilustrasi Maintenance (SVG) -->
            <svg viewBox="0 0 600 300" class="w-full max-w-md mx-auto">
                <defs>
                    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#60a5fa;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#8b5cf6;stop-opacity:1" />
                    </linearGradient>
                </defs>
                <rect x="20" y="180" width="560" height="12" rx="6" fill="#e5e7eb"/>
                <rect x="20" y="180" width="340" height="12" rx="6" fill="url(#grad)"/>
                <g>
                    <circle cx="180" cy="120" r="56" fill="#eef2ff"/>
                    <g transform="translate(180,120)">
                        <g transform="translate(-28,-28)">
                            <rect x="8" y="18" width="40" height="8" rx="4" fill="#6366f1"/>
                            <rect x="8" y="30" width="48" height="8" rx="4" fill="#818cf8"/>
                            <rect x="8" y="42" width="32" height="8" rx="4" fill="#a5b4fc"/>
                        </g>
                        <g transform="translate(8,-16)">
                            <rect x="0" y="0" width="8" height="28" rx="4" fill="#f59e0b"/>
                            <rect x="0" y="30" width="8" height="12" rx="4" fill="#fbbf24"/>
                        </g>
                    </g>
                </g>
                <g>
                    <circle cx="420" cy="120" r="56" fill="#ecfeff"/>
                    <g transform="translate(420,120)">
                        <g transform="translate(-26,-20)">
                            <circle cx="0" cy="0" r="14" fill="#06b6d4"/>
                            <rect x="-6" y="16" width="12" height="32" rx="6" fill="#0891b2"/>
                            <rect x="-22" y="40" width="44" height="6" rx="3" fill="#67e8f9"/>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <h1 class="text-2xl font-bold mb-2">Sedang Pemeliharaan</h1>
        <p class="text-gray-600">{{ $message ?? 'Kami sedang melakukan pemeliharaan untuk meningkatkan kualitas layanan. Mohon coba lagi beberapa saat.' }}</p>
        <div class="mt-6 text-xs text-gray-400">{{ now()->toDayDateTimeString() }}</div>
    </div>
</body>
</html>


