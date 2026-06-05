<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PPE Violation Monitoring Dashboard - Real-time safety monitoring">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-header.png') }}?v=2">

    <!-- PWA Setup -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#f59e0b">
    <link rel="apple-touch-icon" href="{{ asset('image/logo-header.png') }}">

    <title>{{ $title ?? 'Dikemas Ops' }} — Industrial Monitoring</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-100 via-amber-50/20 to-slate-200/40 text-slate-800 antialiased transition-colors duration-300 dark:from-slate-950 dark:to-slate-900 dark:text-slate-200 border-t-4 border-amber-500">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-30 w-64 transform border-r border-slate-200 bg-slate-50 transition-transform duration-200 ease-in-out dark:border-slate-800 dark:bg-slate-900 lg:relative lg:translate-x-0 -translate-x-full">
            <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-6 dark:border-slate-800">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('image/logo-header.png') }}" alt="Logo" class="h-8 w-auto object-contain">
                </div>
                <div>
                    <h1 class="text-sm font-bold text-slate-900 dark:text-white">Dikemas Ops</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Monitoring System</p>
                </div>
            </div>

            <nav class="mt-4 space-y-1 px-3 overflow-y-auto" style="height: calc(100vh - 180px);">
                <a wire:navigate href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>

                <a wire:navigate href="{{ route('violations.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('violations.index') || request()->routeIs('violations.show') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('violations.index') || request()->routeIs('violations.show') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    Violations
                </a>

                <a wire:navigate href="{{ route('violations.heatmap') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('violations.heatmap') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('violations.heatmap') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                    Heatmap
                </a>

                <a wire:navigate href="{{ route('counting.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('counting.*') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('counting.*') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Production Monitoring
                </a>

                <a wire:navigate href="{{ route('api-keys.index') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('api-keys.*') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="h-5 w-5 {{ request()->routeIs('api-keys.*') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    API Keys & Docs
                </a>
            </nav>

            <div
                class="absolute bottom-0 left-0 right-0 border-t border-slate-200 p-4 bg-slate-50 dark:bg-slate-900 dark:border-slate-800">
                @livewire('auth.logout')

            </div>
        </aside>

        {{-- Overlay for mobile sidebar --}}
        <div id="sidebar-overlay"
            class="fixed inset-0 z-20 hidden bg-slate-900/50 backdrop-blur-sm dark:bg-black/50 lg:hidden"
            onclick="toggleSidebar()"></div>

        {{-- Main Content --}}
        <main class="flex-1 overflow-y-auto overflow-x-hidden">
            {{-- Top Bar --}}
            <header
                class="sticky top-0 z-10 flex h-16 items-center gap-6 border-b border-slate-200 bg-slate-50/85 px-6 backdrop-blur-md dark:border-slate-800 dark:bg-slate-950/80 shadow-sm shadow-slate-100/50">
                <button onclick="toggleSidebar()"
                    class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white lg:hidden">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex flex-col">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">System
                        Overview</span>
                    <h2 class="text-base font-bold text-slate-800 dark:text-white">{{ $title ?? 'Dashboard' }}</h2>
                </div>

                {{-- Search Bar --}}
                <div class="relative hidden max-w-xs flex-1 md:block">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Quick search..."
                        class="w-full rounded-lg border border-slate-200 bg-slate-100/60 py-1.5 pl-9 pr-8 text-xs text-slate-700 placeholder-slate-400 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-amber-500 transition-all">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2.5">
                        <kbd
                            class="rounded border border-slate-200 bg-white px-1.5 py-0.5 text-[9px] font-medium text-slate-400 shadow-sm">⌘K</kbd>
                    </div>
                </div>

                <div class="ml-auto flex items-center gap-4">
                    {{-- Status Pill --}}
                    <div
                        class="hidden items-center gap-1.5 rounded-full bg-emerald-50/70 border border-emerald-200/50 px-2.5 py-1 text-xs font-semibold text-emerald-700 md:flex">
                        <span class="relative flex h-1.5 w-1.5">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        </span>
                        Online
                    </div>

                    {{-- Notifications --}}
                    <button
                        class="relative rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition-colors">
                        <span
                            class="absolute top-1.5 right-1.5 h-1.5 w-1.5 rounded-full bg-amber-500 ring-2 ring-slate-50"></span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    {{-- Current Time --}}
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400" id="current-time"></span>

                    {{-- User Profile --}}
                    <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                        <div class="flex flex-col text-right">
                            <span
                                class="text-xs font-semibold text-slate-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                            <span
                                class="text-[9px] text-slate-400">{{ auth()->user()->email ?? 'admin@dikemas.com' }}</span>
                        </div>
                        <div
                            class="h-8 w-8 rounded-lg bg-gradient-to-tr from-amber-500 to-amber-600 flex items-center justify-center text-xs font-bold text-white shadow-sm ring-2 ring-amber-500/20">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
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
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
            if (overlay) overlay.classList.toggle('hidden');
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

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then(registration => {
                    console.log('SW registered: ', registration);
                }).catch(registrationError => {
                    console.log('SW registration failed: ', registrationError);
                });
            });
        }
    </script>
</body>

</html>
