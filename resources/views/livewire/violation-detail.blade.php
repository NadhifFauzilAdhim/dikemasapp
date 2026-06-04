<div>
    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center gap-2 text-sm">
        <a wire:navigate href="{{ route('dashboard') }}" class="text-slate-500 hover:text-slate-700 transition-colors dark:text-slate-500 dark:hover:text-slate-300">Dashboard</a>
        <svg class="h-4 w-4 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a wire:navigate href="{{ route('violations.index') }}" class="text-slate-500 hover:text-slate-700 transition-colors dark:text-slate-500 dark:hover:text-slate-300">Violations</a>
        <svg class="h-4 w-4 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-900 font-medium dark:text-slate-300">#{{ $violation->id }}</span>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Image --}}
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-200 px-5 py-3 dark:border-slate-800">
                    <h3 class="text-sm font-semibold text-slate-900 dark:text-white">Capture Image</h3>
                </div>
                <div class="p-4">
                    @if ($violation->image_path)
                        <img src="{{ $violation->imageUrl }}" alt="Violation #{{ $violation->id }} capture" class="w-full rounded-lg border border-slate-200 shadow-sm dark:border-slate-700">
                    @else
                        <div class="flex h-64 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-slate-500 dark:border-slate-700 dark:bg-slate-900/50">
                            No image available
                        </div>
                    @endif
                </div>
            </div>

            {{-- All Detections --}}
            @if ($violation->all_detections)
                <div class="mt-4 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-200 px-5 py-3 dark:border-slate-800">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white">All Detections in Frame ({{ count($violation->all_detections) }})</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:text-slate-400">
                                    <th class="px-5 py-2 text-left font-semibold">Class</th>
                                    <th class="px-5 py-2 text-left font-semibold">Confidence</th>
                                    <th class="px-5 py-2 text-left font-semibold">BBox</th>
                                    <th class="px-5 py-2 text-left font-semibold">Area</th>
                                    <th class="px-5 py-2 text-left font-semibold">Center</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($violation->all_detections as $detection)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-5 py-2">
                                            <span class="text-slate-900 font-medium dark:text-slate-300">{{ $detection['class_name'] ?? '—' }}</span>
                                            <span class="ml-1 text-xs text-slate-500 dark:text-slate-500">({{ $detection['class_id'] ?? '—' }})</span>
                                        </td>
                                        <td class="px-5 py-2 font-medium text-slate-700 dark:text-slate-300">{{ isset($detection['confidence']) ? number_format($detection['confidence'] * 100, 1) . '%' : '—' }}</td>
                                        <td class="px-5 py-2 font-mono text-xs text-slate-600 dark:text-slate-400">
                                            @if (isset($detection['bbox']))
                                                [{{ $detection['bbox']['x1'] }}, {{ $detection['bbox']['y1'] }}] → [{{ $detection['bbox']['x2'] }}, {{ $detection['bbox']['y2'] }}]
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="px-5 py-2 text-slate-600 dark:text-slate-400">{{ isset($detection['area']) ? number_format($detection['area']) : '—' }}</td>
                                        <td class="px-5 py-2 font-mono text-xs text-slate-600 dark:text-slate-400">
                                            @if (isset($detection['center']))
                                                ({{ $detection['center']['x'] }}, {{ $detection['center']['y'] }})
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar Metadata --}}
        <div class="space-y-4">
            {{-- Violation Info --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-4 text-sm font-semibold text-slate-900 dark:text-white">Violation Details</h3>

                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-slate-500 dark:text-slate-400">Type</dt>
                        <dd class="mt-1">
                            @php
                                $badgeClasses = match($violation->violation_type) {
                                    'NO-Hardhat' => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-500 dark:border-amber-500/20',
                                    'NO-Mask' => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-500/10 dark:text-red-500 dark:border-red-500/20',
                                    'NO-Safety Vest' => 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-500/10 dark:text-orange-500 dark:border-orange-500/20',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-500/10 dark:text-slate-500 dark:border-slate-500/20',
                                };
                            @endphp
                            <span class="rounded-full border px-2.5 py-1 text-xs font-medium {{ $badgeClasses }}">{{ $violation->violation_type }}</span>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-500 dark:text-slate-400">Class ID</dt>
                        <dd class="mt-0.5 font-mono text-sm font-medium text-slate-900 dark:text-white">{{ $violation->violation_class_id }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-500 dark:text-slate-400">Camera</dt>
                        <dd class="mt-1">
                            <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-mono font-medium text-slate-600 dark:bg-slate-800 dark:text-cyan-400">{{ $violation->camera_id }}</span>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-500 dark:text-slate-400">Detected At</dt>
                        <dd class="mt-0.5 text-sm font-medium text-slate-900 dark:text-white">{{ $violation->detected_at->format('d M Y, H:i:s') }}</dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-500 dark:text-slate-400">Confidence</dt>
                        <dd class="mt-1">
                            <div class="flex items-center gap-2">
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                                    <div class="h-full rounded-full {{ $violation->confidence >= 0.8 ? 'bg-emerald-500' : ($violation->confidence >= 0.6 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $violation->confidence * 100 }}%"></div>
                                </div>
                                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ number_format($violation->confidence * 100, 1) }}%</span>
                            </div>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-500 dark:text-slate-400">Person Count</dt>
                        <dd class="mt-0.5 text-sm font-medium text-slate-900 dark:text-white">{{ $violation->person_count }}</dd>
                    </div>

                    @if ($violation->frame_id)
                        <div>
                            <dt class="text-xs text-slate-500 dark:text-slate-400">Frame ID</dt>
                            <dd class="mt-0.5 font-mono text-sm text-slate-700 dark:text-slate-300">{{ $violation->frame_id }}</dd>
                        </div>
                    @endif

                    @if ($violation->inference_time_ms)
                        <div>
                            <dt class="text-xs text-slate-500 dark:text-slate-400">Inference Time</dt>
                            <dd class="mt-0.5 text-sm text-slate-700 dark:text-slate-300">{{ number_format($violation->inference_time_ms, 2) }} ms</dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-xs text-slate-500 dark:text-slate-400">Record Created</dt>
                        <dd class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">{{ $violation->created_at->format('d M Y, H:i:s') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Actions --}}
            <a wire:navigate href="{{ route('violations.index') }}" class="flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition-colors hover:bg-slate-50 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to List
            </a>
        </div>
    </div>
</div>
