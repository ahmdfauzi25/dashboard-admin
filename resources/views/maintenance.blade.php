<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="min-h-screen relative flex items-center justify-center p-6" style="background-color:#0b1d14;">
    <div class="pointer-events-none fixed inset-0 -z-10" style="background-image:
      radial-gradient(1200px 600px at 70% -20%, rgba(34,197,94,.12), rgba(34,197,94,0) 70%),
      radial-gradient(1000px 500px at -10% 20%, rgba(16,185,129,.10), rgba(16,185,129,0) 70%),
      url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"280\" height=\"280\" viewBox=\"0 0 280 280\"><g fill=\"none\" fill-rule=\"evenodd\" opacity=\"0.12\"><path d=\"M30 70c30-40 60-40 90 0-30 10-60 10-90 0z\" fill=\"%2316a34a\"/><path d=\"M180 210c25-30 50-30 75 0-25 8-50 8-75 0z\" fill=\"%2322c55e\"/><circle cx=\"220\" cy=\"70\" r=\"20\" fill=\"%231a9f57\"/><circle cx=\"80\" cy=\"210\" r=\"14\" fill=\"%2322c55e\"/></g></svg></div>
    <div class="pointer-events-none fixed inset-0 -z-10" style="opacity:.12; background-image:url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"800\" height=\"800\" viewBox=\"0 0 800 800\"><g fill=\"%230a3d2a\"><path d=\"M120 200c60-80 120-80 180 0-60 20-120 20-180 0z\"/><path d=\"M520 640c50-60 100-60 150 0-50 16-100 16-150 0z\"/><circle cx=\"640\" cy=\"200\" r=\"40\"/><circle cx=\"240\" cy=\"640\" r=\"28\"/></g></svg>'</div>
    <style>@keyframes leavesDrift{from{background-position:0 0}to{background-position:-800px -400px}}</style>

    <div class="max-w-2xl w-full rounded-2xl shadow-modern-lg p-8 text-center" style="background:rgba(10,25,18,.7); backdrop-filter:blur(10px); color:#e6f4ea; border:1px solid rgba(34,197,94,.18)">
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
        <p class="opacity-90">{{ $message ?? 'Kami sedang melakukan pemeliharaan untuk meningkatkan kualitas layanan. Mohon coba lagi beberapa saat.' }}</p>
        <div class="mt-6 text-xs opacity-70">{{ now()->toDayDateTimeString() }}</div>
    </div>
</body>
</html>


