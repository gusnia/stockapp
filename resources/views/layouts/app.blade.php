<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SyariahWatch')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Syne', 'sans-serif'],
                        mono: ['Space Mono', 'monospace'],
                    },
                    colors: {
                        navy: {
                            950: '#050d1a',
                            900: '#080f20',
                            800: '#0d1830',
                            700: '#112040',
                            600: '#162850',
                        },
                        cyan: {
                            400: '#22d3ee',
                            500: '#06b6d4',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #050d1a; }

        .sidebar-item {
            transition: all 0.2s ease;
        }
        .sidebar-item:hover, .sidebar-item.active {
            background: linear-gradient(90deg, rgba(34,211,238,0.15) 0%, transparent 100%);
            border-left: 2px solid #22d3ee;
            color: #22d3ee;
        }

        .card-glow {
            box-shadow: 0 0 30px rgba(34, 211, 238, 0.05);
            border: 1px solid rgba(34, 211, 238, 0.1);
        }
        .card-glow:hover {
            box-shadow: 0 0 40px rgba(34, 211, 238, 0.12);
            border-color: rgba(34, 211, 238, 0.25);
            transition: all 0.3s ease;
        }

        .bg-mesh {
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(34,211,238,0.05) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(96,165,250,0.05) 0%, transparent 60%);
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #0d1830; }
        ::-webkit-scrollbar-thumb { background: #22d3ee33; border-radius: 2px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.4s ease forwards; }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.3; }
        }
        .live-dot { animation: pulse-dot 1.5s ease infinite; }
    </style>
    @stack('styles')
</head>
<body class="bg-navy-950 text-slate-300 font-display min-h-screen bg-mesh">

<div class="flex min-h-screen">
    {{-- area kode Sidebar --}}
    <aside class="hidden lg:flex flex-col w-60 bg-navy-900 border-r border-white/5 fixed h-full z-20">
        {{-- Logo --}}
        <div class="p-6 border-b border-white/5">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-cyan-500/20 flex items-center justify-center border border-cyan-500/30">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-lg tracking-tight">SyariahWatch</span>
            </div>
        </div>

        {{-- area kode Nav --}}
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('market.watch') }}" class="sidebar-item {{ request()->routeIs('market.watch') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-slate-300 border-l-2 border-transparent">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Market Watch
            </a>
        </nav>

        {{-- area kode Bottom --}}
        <div class="p-4 border-t border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-cyan-500/20 border border-cyan-500/30 flex items-center justify-center text-xs text-cyan-400 font-bold">U</div>
                <div>
                    <p class="text-xs text-white font-semibold">User</p>
                    <p class="text-xs text-slate-500">Investor Syariah</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- Area content utama  --}}
    <div class="flex-1 lg:ml-60 flex flex-col">
        {{-- area kode Topbar --}}
        <header class="sticky top-0 z-10 bg-navy-900/80 backdrop-blur border-b border-white/5 px-4 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2 lg:hidden">
                <div class="w-7 h-7 rounded-lg bg-cyan-500/20 flex items-center justify-center border border-cyan-500/30">
                    <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-base">SyariahWatch</span>
            </div>
            <div class="hidden lg:block">
                <h1 class="text-white font-bold text-xl">@yield('page-title', 'Dashboard')</h1>
                <p class="text-xs text-slate-500">@yield('page-subtitle', '')</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-full px-3 py-1">
                    <span class="live-dot w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span class="text-emerald-400 text-xs font-mono font-bold">LIVE</span>
                </div>
                <div class="text-xs text-slate-500 font-mono hidden sm:block" id="clock"></div>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-8">
            @yield('content')
        </main>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').textContent =
            now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@stack('scripts')
</body>
</html>