@props(['title' => 'Dashboard'])

<header
    class="sticky top-0 z-10 flex h-16 items-center gap-6 border-b border-slate-200 bg-slate-50/85 px-6 backdrop-blur-md dark:border-slate-800 dark:bg-slate-950/80 shadow-sm shadow-slate-100/50">
    <button onclick="toggleSidebar()"
        class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white lg:hidden">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <div class="flex flex-col">
        <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">System
            Overview</span>
        <h2 class="text-base font-bold text-slate-800 dark:text-white">{{ $title }}</h2>
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

        {{-- Notifications --}}
        <button
            class="relative rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition-colors">
            <span class="absolute top-1.5 right-1.5 h-1.5 w-1.5 rounded-full bg-amber-500 ring-2 ring-slate-50"></span>
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
                <span class="text-xs font-semibold text-slate-700">{{ auth()->user()->name ?? 'Admin' }}</span>
                <span class="text-[9px] text-slate-400">{{ auth()->user()->email ?? 'admin@dikemas.com' }}</span>
            </div>
            <div
                class="h-8 w-8 rounded-lg bg-gradient-to-tr from-amber-500 to-amber-600 flex items-center justify-center text-xs font-bold text-white shadow-sm ring-2 ring-amber-500/20">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </div>
</header>
