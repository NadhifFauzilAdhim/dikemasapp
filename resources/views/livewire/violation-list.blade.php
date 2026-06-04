<div>
    @section('title', 'Violations')

    {{-- Filters --}}
    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition-shadow hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-400">Camera</label>
                <select wire:model.live="cameraFilter" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                    <option value="">All Cameras</option>
                    @foreach ($this->cameras as $camera)
                        <option value="{{ $camera }}">{{ $camera }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-400">Type</label>
                <select wire:model.live="typeFilter" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                    <option value="">All Types</option>
                    <option value="NO-Hardhat">NO-Hardhat</option>
                    <option value="NO-Mask">NO-Mask</option>
                    <option value="NO-Safety Vest">NO-Safety Vest</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-400">From</label>
                <input type="date" wire:model.live="dateFrom" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-400">To</label>
                <input type="date" wire:model.live="dateTo" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-xs font-medium text-slate-700 dark:text-slate-400">Min Confidence</label>
                <input type="number" wire:model.live.debounce.500ms="minConfidence" min="0" max="1" step="0.1" placeholder="0.0" class="w-24 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
            </div>

            <button wire:click="resetFilters" class="rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-600 shadow-sm transition-colors hover:bg-slate-100 hover:text-slate-900 dark:border-slate-700 dark:bg-transparent dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white">
                Reset
            </button>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-left text-xs uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:text-slate-400">
                        <th class="cursor-pointer px-5 py-3 font-semibold transition-colors hover:text-slate-800 dark:hover:text-slate-300" wire:click="sortBy('detected_at')">
                            <div class="flex items-center gap-1">
                                Time
                                @if ($sortField === 'detected_at')
                                    <svg class="h-3 w-3 {{ $sortDirection === 'asc' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                @endif
                            </div>
                        </th>
                        <th class="cursor-pointer px-5 py-3 font-semibold transition-colors hover:text-slate-800 dark:hover:text-slate-300" wire:click="sortBy('camera_id')">
                            <div class="flex items-center gap-1">
                                Camera
                                @if ($sortField === 'camera_id')
                                    <svg class="h-3 w-3 {{ $sortDirection === 'asc' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-5 py-3 font-semibold">Type</th>
                        <th class="cursor-pointer px-5 py-3 font-semibold transition-colors hover:text-slate-800 dark:hover:text-slate-300" wire:click="sortBy('confidence')">
                            <div class="flex items-center gap-1">
                                Confidence
                                @if ($sortField === 'confidence')
                                    <svg class="h-3 w-3 {{ $sortDirection === 'asc' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                @endif
                            </div>
                        </th>
                        <th class="px-5 py-3 font-semibold">Persons</th>
                        <th class="px-5 py-3 font-semibold">Frame</th>
                        <th class="px-5 py-3 font-semibold">Inference</th>
                        <th class="px-5 py-3 font-semibold">Image</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($this->violations as $violation)
                        <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                            <td class="whitespace-nowrap px-5 py-3 text-slate-900 dark:text-slate-300">
                                <span class="font-medium">{{ $violation->detected_at->format('d M Y') }}</span>
                                <span class="block text-xs text-slate-500 dark:text-slate-400">{{ $violation->detected_at->format('H:i:s') }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-medium font-mono text-slate-600 dark:bg-slate-800 dark:text-cyan-400">{{ $violation->camera_id }}</span>
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
                                    <div class="h-1.5 w-12 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                                        <div class="h-full rounded-full {{ $violation->confidence >= 0.8 ? 'bg-emerald-500' : ($violation->confidence >= 0.6 ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $violation->confidence * 100 }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">{{ number_format($violation->confidence * 100, 1) }}%</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-center font-medium text-slate-900 dark:text-slate-300">{{ $violation->person_count }}</td>
                            <td class="px-5 py-3 text-xs font-mono text-slate-600 dark:text-slate-500">{{ $violation->frame_id ?? '—' }}</td>
                            <td class="px-5 py-3 text-xs font-medium text-slate-600 dark:text-slate-500">{{ $violation->inference_time_ms ? number_format($violation->inference_time_ms, 1) . 'ms' : '—' }}</td>
                            <td class="px-5 py-3">
                                @if ($violation->image_path)
                                    <img src="{{ $violation->imageUrl }}" alt="Capture" class="h-10 w-14 rounded object-cover border border-slate-200 shadow-sm dark:border-slate-700" loading="lazy">
                                @else
                                    <span class="text-xs text-slate-400 dark:text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a wire:navigate href="{{ route('violations.show', $violation) }}" class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-medium text-amber-600 transition-colors hover:bg-amber-50 dark:text-amber-500 dark:hover:bg-amber-500/10">
                                    Detail
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-5 py-12 text-center text-slate-500 dark:text-slate-500">
                                <svg class="mx-auto mb-3 h-8 w-8 text-slate-400 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                No violations found matching your filters
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($this->violations->hasPages())
            <div class="border-t border-slate-200 bg-slate-50 px-5 py-3 dark:border-slate-800 dark:bg-transparent">
                {{ $this->violations->links() }}
            </div>
        @endif
    </div>
</div>
