<div wire:poll.3s>
    {{-- Summary Cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        {{-- Active Devices --}}
        <div class="relative overflow-hidden rounded-xl border border-emerald-200 bg-gradient-to-br from-emerald-400 to-emerald-500 p-5 shadow-lg shadow-emerald-500/20 dark:border-emerald-500/20 dark:from-emerald-500/20 dark:to-emerald-600/20 dark:shadow-none">
            <div class="relative z-10 flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-emerald-50 dark:text-emerald-400">Active Devices</p>
                <span class="rounded-lg bg-white/20 p-2 text-white backdrop-blur-sm dark:bg-emerald-500/10 dark:text-emerald-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                </span>
            </div>
            <p class="relative z-10 mt-3 text-4xl font-black text-white dark:text-emerald-400">{{ $this->activeCount }}</p>
            <p class="relative z-10 mt-1 text-xs font-medium text-emerald-100 dark:text-emerald-500/70">devices online</p>

            <svg class="absolute -bottom-4 -right-4 h-32 w-32 text-white opacity-10 dark:text-emerald-500 dark:opacity-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
        </div>

        {{-- Total Live Count --}}
        <div class="relative overflow-hidden rounded-xl border border-amber-200 bg-gradient-to-br from-amber-400 to-amber-500 p-5 shadow-lg shadow-amber-500/20 dark:border-amber-500/20 dark:from-amber-500/20 dark:to-amber-600/20 dark:shadow-none">
            <div class="relative z-10 flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-amber-50 dark:text-amber-400">Live Count</p>
                <span class="rounded-lg bg-white/20 p-2 text-white backdrop-blur-sm dark:bg-amber-500/10 dark:text-amber-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                </span>
            </div>
            <p class="relative z-10 mt-3 text-4xl font-black text-white dark:text-amber-400">{{ number_format($this->totalProduction) }}</p>
            <p class="relative z-10 mt-1 text-xs font-medium text-amber-100 dark:text-amber-500/70">products counted</p>

            <svg class="absolute -bottom-4 -right-4 h-32 w-32 text-white opacity-10 dark:text-amber-500 dark:opacity-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
        </div>

        {{-- Total Sessions --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Sessions</p>
                <span class="rounded-lg bg-amber-50 p-2 dark:bg-amber-500/10">
                    <svg class="h-4 w-4 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $this->totalSessions }}</p>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-500">registered devices</p>
        </div>
    </div>

    {{-- Auto-refresh indicator --}}
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Device Sessions</h3>
        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
            <span class="relative flex h-2 w-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
            </span>
            Auto-refresh: 3s
        </div>
    </div>

    {{-- Device Cards Grid --}}
    @if ($this->sessions->isNotEmpty())
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($this->sessions as $session)
                @php
                    $displayStatus = $session->display_status;
                    $statusConfig = match($displayStatus) {
                        'running' => [
                            'dot' => 'bg-emerald-500',
                            'ping' => 'bg-emerald-400',
                            'badge' => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20',
                            'border' => 'border-emerald-200 dark:border-emerald-500/20',
                            'label' => 'Running',
                        ],
                        'started' => [
                            'dot' => 'bg-blue-500',
                            'ping' => 'bg-blue-400',
                            'badge' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20',
                            'border' => 'border-blue-200 dark:border-blue-500/20',
                            'label' => 'Starting',
                        ],
                        'disconnected' => [
                            'dot' => 'bg-amber-500',
                            'ping' => 'bg-amber-400',
                            'badge' => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20',
                            'border' => 'border-amber-200 dark:border-amber-500/20',
                            'label' => 'Disconnected',
                        ],
                        default => [
                            'dot' => 'bg-slate-400',
                            'ping' => 'bg-slate-300',
                            'badge' => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-500/10 dark:text-slate-400 dark:border-slate-500/20',
                            'border' => 'border-slate-200 dark:border-slate-800',
                            'label' => 'Stopped',
                        ],
                    };
                @endphp

                <div class="rounded-xl border {{ $statusConfig['border'] }} bg-white p-5 shadow-sm transition-all hover:shadow-md dark:bg-slate-900">
                    {{-- Header --}}
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-800">
                                <svg class="h-5 w-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $session->device_id }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ Str::limit($session->source_id, 35) ?: 'No source' }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-xs font-medium {{ $statusConfig['badge'] }}">
                            <span class="relative flex h-2 w-2">
                                @if ($displayStatus === 'running')
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full {{ $statusConfig['ping'] }} opacity-75"></span>
                                @endif
                                <span class="relative inline-flex h-2 w-2 rounded-full {{ $statusConfig['dot'] }}"></span>
                            </span>
                            {{ $statusConfig['label'] }}
                        </span>
                    </div>

                    {{-- Count Display --}}
                    <div class="mt-4 rounded-lg bg-slate-50 p-4 text-center dark:bg-slate-800/50">
                        <p class="text-4xl font-black tabular-nums {{ $displayStatus === 'running' ? 'text-amber-600 dark:text-amber-400' : 'text-slate-400 dark:text-slate-500' }}">
                            {{ number_format($session->current_count) }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">products counted</p>
                    </div>

                    {{-- Details --}}
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">FPS</span>
                            <span class="font-mono font-medium text-slate-700 dark:text-slate-300">{{ $session->fps ? number_format($session->fps, 1) : '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">Uptime</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ $session->uptime }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 dark:text-slate-400">Last Heartbeat</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">
                                {{ $session->last_heartbeat_at ? $session->last_heartbeat_at->diffForHumans() : '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800">
                <svg class="h-8 w-8 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">No devices connected</h3>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Start the counting application with <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs font-mono dark:bg-slate-800">--realtime</code> flag to see live data here.
            </p>
            <div class="mt-4 rounded-lg bg-slate-50 p-4 text-left dark:bg-slate-800/50">
                <p class="mb-2 text-xs font-medium text-slate-500 dark:text-slate-400">Example:</p>
                <code class="block text-xs text-slate-700 dark:text-slate-300 font-mono break-all">python main.py --source 0 --api-url http://localhost:8000 --realtime --realtime-token YOUR_TOKEN</code>
            </div>
        </div>
    @endif
</div>
