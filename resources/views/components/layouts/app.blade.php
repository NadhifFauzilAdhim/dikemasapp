<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PPE Violation Monitoring Dashboard - Real-time safety monitoring">

    <title>{{ $title ?? 'PPE Monitoring' }} — DikemasApp</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50/40 to-slate-50 text-slate-800 antialiased transition-colors duration-300 dark:from-slate-950 dark:to-slate-900 dark:text-slate-200 border-t-4 border-amber-500">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 transform border-r border-slate-200 bg-white transition-transform duration-200 ease-in-out dark:border-slate-800 dark:bg-slate-900 lg:relative lg:translate-x-0 -translate-x-full">
            <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-6 dark:border-slate-800">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-amber-500 to-red-600 shadow-sm shadow-amber-500/20">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-slate-900 dark:text-white">PPE Monitor</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">DikemasApp</p>
                </div>
            </div>

            <nav class="mt-4 space-y-1 px-3">
                <a wire:navigate href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>

                <a wire:navigate href="{{ route('violations.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('violations.*') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('violations.*') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    Violations
                </a>

                <a wire:navigate href="{{ route('api-keys.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('api-keys.*') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('api-keys.*') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    API Keys
                </a>

                <a wire:navigate href="{{ route('counting.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('counting.*') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('counting.*') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Production Monitoring
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 border-t border-slate-200 p-4 dark:border-slate-800">
                @livewire('auth.logout')
                <div class="mt-4 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-600">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>
                    System Active
                </div>
            </div>
        </aside>

        {{-- Overlay for mobile sidebar --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden bg-slate-900/50 backdrop-blur-sm dark:bg-black/50 lg:hidden" onclick="toggleSidebar()"></div>

        {{-- Main Content --}}
        <main class="flex-1 overflow-auto">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-10 flex h-16 items-center gap-4 border-b border-slate-200 bg-white/80 px-6 backdrop-blur-md dark:border-slate-800 dark:bg-slate-950/80">
                <button onclick="toggleSidebar()" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white lg:hidden">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $title ?? 'Dashboard' }}</h2>

                <div class="ml-auto flex items-center gap-4">
                    <span class="text-xs text-slate-500 dark:text-slate-400" id="current-time"></span>
                </div>
            </header>

            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    <script data-navigate-once>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if(sidebar) sidebar.classList.toggle('-translate-x-full');
            if(overlay) overlay.classList.toggle('hidden');
        }

        document.addEventListener('livewire:navigated', function() {
            // Time logic
            function updateTime() {
                const el = document.getElementById('current-time');
                if (el) {
                    el.textContent = new Date().toLocaleString('id-ID', {
                        dateStyle: 'medium',
                        timeStyle: 'medium'
                    });
                }
            }
            updateTime();
            if (window.timeInterval) clearInterval(window.timeInterval);
            window.timeInterval = setInterval(updateTime, 1000);
        });
    </script>
</body>
</html>
