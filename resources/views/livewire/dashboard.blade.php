<div wire:poll.10s>
    {{-- Auto-refresh Indicator --}}
    <div class="mb-6 flex justify-end">
        <div class="flex items-center gap-2 rounded-full border border-slate-200/80 bg-white/60 px-3 py-1.5 text-xs font-medium text-slate-500 shadow-sm backdrop-blur-sm dark:border-slate-800 dark:bg-slate-900/60 dark:text-slate-400">
            <span class="relative flex h-1.5 w-1.5">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
            </span>
            Auto-refresh: 10s
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
        {{-- Today --}}
        <div class="relative overflow-hidden rounded-xl border border-amber-200 bg-amber-50/60 p-5 shadow-sm transition-shadow hover:shadow-md dark:border-amber-500/20 dark:from-amber-500/20 dark:to-amber-600/20 dark:bg-none">
            <div class="relative z-10 flex items-center justify-between">
                <p class="text-xs font-bold uppercase tracking-wider text-amber-700 dark:text-amber-400">Today</p>
                <span class="rounded-lg bg-amber-100 p-2 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                    <svg class="h-4 w-4 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <p class="relative z-10 mt-3 text-4xl font-black text-amber-900 dark:text-amber-400">{{ number_format($this->todayCount) }}</p>
            <p class="relative z-10 mt-1 text-xs font-medium text-amber-700/80 dark:text-amber-500/70">violations detected</p>
            
            <svg class="absolute -bottom-4 -right-4 h-32 w-32 text-amber-600 opacity-5 dark:text-amber-500 dark:opacity-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>

        {{-- This Week --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">This Week</p>
                <span class="rounded-lg bg-amber-50 p-2 dark:bg-amber-500/10">
                    <svg class="h-4 w-4 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ number_format($this->weekCount) }}</p>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-500">violations this week</p>
        </div>

        {{-- This Month --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">This Month</p>
                <span class="rounded-lg bg-amber-50 p-2 dark:bg-amber-500/10">
                    <svg class="h-4 w-4 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002-2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ number_format($this->monthCount) }}</p>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-500">violations this month</p>
        </div>

        {{-- Avg Confidence --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Avg Confidence</p>
                <span class="rounded-lg bg-amber-50 p-2 dark:bg-amber-500/10">
                    <svg class="h-4 w-4 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $this->averageConfidence > 0 ? number_format($this->averageConfidence * 100, 1) . '%' : '—' }}</p>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-500">detection accuracy</p>
        </div>

        {{-- Active Cameras --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800">
            <div class="flex items-center justify-between">
                <p class="text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Active Cameras</p>
                <span class="rounded-lg bg-amber-50 p-2 dark:bg-amber-500/10">
                    <svg class="h-4 w-4 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900 dark:text-white">{{ $this->activeCameras }}</p>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-500">cameras today</p>
        </div>
    </div>

    {{-- Violation Type Breakdown --}}
    <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
        @php $types = $this->typeCounts; $total = max(array_sum($types), 1); @endphp

        {{-- NO-Hardhat --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 dark:bg-amber-500/10">
                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-slate-900 dark:text-white">NO-Hardhat</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Today's count</p>
                    </div>
                </div>
                <p class="text-2xl font-bold text-amber-600 dark:text-amber-500">{{ $types['NO-Hardhat'] }}</p>
            </div>
            <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                <div class="h-full rounded-full bg-amber-500 transition-all duration-500" style="width: {{ round($types['NO-Hardhat'] / $total * 100) }}%"></div>
            </div>
        </div>

        {{-- NO-Mask --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 dark:bg-red-500/10">
                        <svg class="h-5 w-5 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-slate-900 dark:text-white">NO-Mask</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Today's count</p>
                    </div>
                </div>
                <p class="text-2xl font-bold text-red-600 dark:text-red-500">{{ $types['NO-Mask'] }}</p>
            </div>
            <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                <div class="h-full rounded-full bg-red-500 transition-all duration-500" style="width: {{ round($types['NO-Mask'] / $total * 100) }}%"></div>
            </div>
        </div>

        {{-- NO-Safety Vest --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-50 dark:bg-orange-500/10">
                        <svg class="h-5 w-5 text-orange-600 dark:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <div>
                        <p class="text-sm font-medium text-slate-900 dark:text-white">NO-Safety Vest</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Today's count</p>
                    </div>
                </div>
                <p class="text-2xl font-bold text-orange-600 dark:text-orange-500">{{ $types['NO-Safety Vest'] }}</p>
            </div>
            <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                <div class="h-full rounded-full bg-orange-500 transition-all duration-500" style="width: {{ round($types['NO-Safety Vest'] / $total * 100) }}%"></div>
            </div>
        </div>
    </div>

    {{-- Trend Chart --}}
    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900" wire:ignore>
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Violation Trends</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Last 7 days</p>
            </div>
        </div>
        <div id="violation-chart" class="-ml-2"></div>
    </div>

    {{-- Chart Initialization Script --}}
    @script
    <script>
        let chart = null;

        const initChart = () => {
            const chartData = $wire.chartData;
            const isDark = false; // Forced Light Mode
            
            const options = {
                series: [{
                    name: 'Violations',
                    data: chartData.data
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    fontFamily: 'inherit',
                    toolbar: { show: false },
                    animations: { enabled: true },
                    background: 'transparent'
                },
                colors: ['#f59e0b'], // Amber 500
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: chartData.categories,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#64748b',
                        },
                        formatter: (val) => { return Math.round(val) }
                    }
                },
                grid: {
                    borderColor: '#e2e8f0',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } },
                    padding: { top: 0, right: 0, bottom: 0, left: 10 }
                },
                theme: {
                    mode: 'light'
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return val + " violations"
                        }
                    }
                }
            };

            if (chart) {
                chart.destroy();
            }

            chart = new ApexCharts(document.querySelector("#violation-chart"), options);
            chart.render();
        };

        // Initialize when component loads
        initChart();

        // Listen for data updates
        $wire.on('chart-updated', () => {
            initChart();
        });
    </script>
    @endscript

    {{-- Recent Violations Feed --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-slate-800">
            <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Recent Violations</h3>
            <a wire:navigate href="{{ route('violations.index') }}" class="text-xs font-medium text-amber-600 hover:text-amber-500 transition-colors dark:text-amber-500 dark:hover:text-amber-400">View All →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-left text-xs uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:text-slate-400">
                        <th class="px-5 py-3 font-semibold">Time</th>
                        <th class="px-5 py-3 font-semibold">Camera</th>
                        <th class="px-5 py-3 font-semibold">Type</th>
                        <th class="px-5 py-3 font-semibold">Confidence</th>
                        <th class="px-5 py-3 font-semibold">Persons</th>
                        <th class="px-5 py-3 font-semibold">Image</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($this->recentViolations as $violation)
                        <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="whitespace-nowrap px-5 py-3 text-slate-900 dark:text-slate-300">
                                <span class="font-medium">{{ $violation->detected_at->format('H:i:s') }}</span>
                                <span class="block text-xs text-slate-500 dark:text-slate-400">{{ $violation->detected_at->format('d M Y') }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-mono font-medium text-slate-600 dark:bg-slate-800 dark:text-cyan-400">{{ $violation->camera_id }}</span>
                            </td>
                            <td class="px-5 py-3">
                                @php
                                    $badgeClasses = match($violation->violation_type) {
                                        'NO-Hardhat' => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-500 dark:border-amber-500/20',
                                        'NO-Mask' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-500/10 dark:text-red-500 dark:border-red-500/20',
                                        'NO-Safety Vest' => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-500/10 dark:text-orange-500 dark:border-orange-500/20',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-500/10 dark:text-slate-500 dark:border-slate-500/20',
                                    };
                                @endphp
                                <span class="rounded-full border px-2.5 py-1 text-xs font-medium {{ $badgeClasses }}">{{ $violation->violation_type }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 w-16 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                                        <div class="h-full rounded-full {{ $violation->confidence >= 0.8 ? 'bg-emerald-500' : ($violation->confidence >= 0.6 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $violation->confidence * 100 }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ number_format($violation->confidence * 100, 1) }}%</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-center font-medium text-slate-900 dark:text-slate-300">{{ $violation->person_count }}</td>
                            <td class="px-5 py-3">
                                @if ($violation->image_path)
                                    <img src="{{ $violation->imageUrl }}" alt="Violation capture" class="h-10 w-14 rounded object-cover border border-slate-200 shadow-sm dark:border-slate-700" loading="lazy">
                                @else
                                    <span class="text-xs text-slate-400 dark:text-slate-600">No image</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a wire:navigate href="{{ route('violations.show', $violation) }}" class="inline-flex rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-white">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                                <svg class="mx-auto h-8 w-8 text-slate-400 mb-3 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                No violations detected yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
