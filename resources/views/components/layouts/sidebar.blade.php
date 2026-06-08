<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-30 w-64 transform border-r border-slate-200 bg-slate-50 transition-transform duration-200 ease-in-out dark:border-slate-800 dark:bg-slate-900 lg:relative lg:translate-x-0 -translate-x-full">
    <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-6 dark:border-slate-800">
        @persist('sidebar-logo')
            <div class="flex items-center justify-center">
                <img src="{{ asset('image/logo-header.png') }}" alt="Logo" class="h-8 w-auto object-contain">
            </div>
        @endpersist
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

        <a wire:navigate href="{{ route('attendance.index') }}"
            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('attendance.*') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('attendance.*') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Absensi
        </a>

        <a wire:navigate href="{{ route('counting.index') }}"
            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('counting.*') ? 'bg-amber-500 text-white shadow-md shadow-amber-500/20 dark:bg-amber-500/20 dark:text-amber-400 dark:shadow-none' : 'text-slate-600 hover:bg-amber-50 hover:text-amber-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
            <svg class="h-5 w-5 {{ request()->routeIs('counting.*') ? 'text-white dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002-2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
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
