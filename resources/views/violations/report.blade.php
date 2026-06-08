<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 dark:bg-slate-950">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HSE Report #{{ $violation->id }} - Dikemas Ops</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body {
                background-color: white !important;
                color: black !important;
            }

            .no-print {
                display: none !important;
            }

            .print-card {
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
            }

            .print-break-inside-avoid {
                break-inside: avoid;
            }

            @page {
                size: A4;
                margin: 1.5cm;
            }
        }
    </style>
</head>

<body class="h-full text-slate-900 antialiased font-sans dark:text-slate-100">
    <!-- Floating Action Bar (Hidden on print) -->
    <div
        class="no-print sticky top-0 z-50 flex items-center justify-between border-b border-slate-200 bg-white/80 px-6 py-4 shadow-sm backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/80">
        <div class="flex items-center gap-3">
            <a href="{{ route('violations.show', $violation) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Details
            </a>
            <div class="h-5 w-px bg-slate-200 dark:bg-slate-800"></div>
            <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">Incident Report Generator</span>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-xs font-semibold text-white shadow-sm transition-all hover:bg-amber-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print / Save as PDF
            </button>
        </div>
    </div>

    <!-- Page Wrapper -->
    <div class="mx-auto max-w-4xl p-6 sm:p-12">
        <div
            class="print-card overflow-hidden rounded-2xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <!-- Header Section -->
            <div
                class="flex flex-col justify-between border-b border-slate-200 pb-6 dark:border-slate-800 md:flex-row md:items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/logo-header.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-800"></div>
                    <div>
                        <h1 class="text-base font-bold uppercase tracking-wide text-slate-900 dark:text-white">DIKEMAS
                            SAFETY OPS</h1>
                    </div>
                </div>
                <div class="mt-4 text-left md:mt-0 md:text-right">
                    <span
                        class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-bold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">
                        VIOLATION DETECTED
                    </span>
                    <p class="mt-2 font-mono text-xs text-slate-500 dark:text-slate-400">Doc ID:
                        HSE-{{ now()->format('Y') }}-{{ str_pad($violation->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Title -->
            <div class="my-6">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">HSE Incident Investigation Report</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Automated AI safety inspector record generated for
                    audit compliance verification.</p>
            </div>

            <!-- Incident Metadata Grid -->
            <div
                class="grid grid-cols-2 gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4 dark:border-slate-800 dark:bg-slate-900/50 sm:grid-cols-3">
                <div>
                    <span class="block text-[10px] uppercase font-bold text-slate-400">Camera Device</span>
                    <span
                        class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $violation->camera_id }}</span>
                </div>
                <div>
                    <span class="block text-[10px] uppercase font-bold text-slate-400">Timestamp</span>
                    <span
                        class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $violation->detected_at?->format('Y-m-d H:i:s') ?? '—' }}</span>
                </div>
                <div>
                    <span class="block text-[10px] uppercase font-bold text-slate-400">Primary Violation</span>
                    <span
                        class="text-sm font-semibold text-rose-600 dark:text-rose-400">{{ $violation->violation_type }}</span>
                </div>
                <div>
                    <span class="block text-[10px] uppercase font-bold text-slate-400">Detection Confidence</span>
                    <span
                        class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ number_format($violation->confidence * 100, 1) }}%</span>
                </div>
                <div>
                    <span class="block text-[10px] uppercase font-bold text-slate-400">Personnel in Frame</span>
                    <span
                        class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $violation->raw_payload['person_count'] ?? 1 }}
                        Person(s)</span>
                </div>
                <div>
                    <span class="block text-[10px] uppercase font-bold text-slate-400">Inference Speed</span>
                    <span
                        class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $violation->raw_payload['inference_time_ms'] ?? '—' }}
                        ms</span>
                </div>
            </div>

            <!-- Captured Evidence BBox Overlay -->
            <div class="my-6">
                <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">Evidence Capture (Annotated
                    View)</h3>
                @if ($violation->image_path)
                    <div
                        class="relative w-full overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800">
                        <img src="{{ $violation->imageUrl }}" alt="Incident capture"
                            class="w-full h-auto block select-none">

                        <!-- Bounding Box Overlays -->
                        <div class="absolute inset-0 pointer-events-none select-none z-20">
                            @php
                                $detections = $violation->all_detections ?? [
                                    [
                                        'class_name' => $violation->violation_type,
                                        'class_id' => $violation->violation_class_id,
                                        'confidence' => $violation->confidence,
                                        'bbox' => $violation->bbox,
                                    ],
                                ];
                                $cameraWidth = $violation->raw_payload['camera_width'] ?? 1280;
                                $cameraHeight = $violation->raw_payload['camera_height'] ?? 720;
                            @endphp
                            @foreach ($detections as $index => $det)
                                @if (isset($det['bbox']))
                                    @php
                                        $bbox = $det['bbox'];
                                        $left = ($bbox['x1'] / $cameraWidth) * 100;
                                        $top = ($bbox['y1'] / $cameraHeight) * 100;
                                        $width = (($bbox['x2'] - $bbox['x1']) / $cameraWidth) * 100;
                                        $height = (($bbox['y2'] - $bbox['y1']) / $cameraHeight) * 100;
                                        $className = strtolower($det['class_name'] ?? '');

                                        if (str_contains($className, 'no-') || str_contains($className, 'violation')) {
                                            $borderClass = 'border-rose-500 bg-rose-500/10';
                                            $badgeClass = 'bg-rose-500 text-white';
                                        } elseif (str_contains($className, 'person')) {
                                            $borderClass = 'border-blue-500 bg-blue-500/10';
                                            $badgeClass = 'bg-blue-500 text-white';
                                        } else {
                                            $borderClass = 'border-emerald-500 bg-emerald-500/10';
                                            $badgeClass = 'bg-emerald-500 text-white';
                                        }
                                    @endphp
                                    <div class="absolute border-2 {{ $borderClass }}"
                                        style="left: {{ $left }}%; top: {{ $top }}%; width: {{ $width }}%; height: {{ $height }}%;">
                                        <div
                                            class="absolute -top-4 left-0 px-1 py-0.5 rounded text-[8px] font-bold {{ $badgeClass }} whitespace-nowrap shadow-sm">
                                            {{ $det['class_name'] }}
                                            ({{ number_format(($det['confidence'] ?? 0) * 100, 0) }}%)
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <div
                        class="flex h-48 items-center justify-center rounded-xl border border-dashed border-slate-300 bg-slate-50 text-slate-400 dark:border-slate-800 dark:bg-slate-900/50">
                        Image capture not found
                    </div>
                @endif
            </div>

            <!-- Complete Detections Table -->
            <div class="my-6 print-break-inside-avoid">
                <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">Safety compliance breakdown
                </h3>
                <div class="overflow-hidden rounded-xl border border-slate-100 dark:border-slate-800">
                    <table class="w-full text-left text-xs">
                        <thead
                            class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] dark:bg-slate-900/50 dark:text-slate-400">
                            <tr>
                                <th class="px-4 py-2 font-bold">Class Name</th>
                                <th class="px-4 py-2 font-bold">Category</th>
                                <th class="px-4 py-2 font-bold">Confidence</th>
                                <th class="px-4 py-2 font-bold">Coordinates (X1, Y1, X2, Y2)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($detections as $det)
                                @php
                                    $className = strtolower($det['class_name'] ?? '');
                                    $isViol = str_contains($className, 'no-') || str_contains($className, 'violation');
                                    $isPerson = str_contains($className, 'person');
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                    <td class="px-4 py-2.5 font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $det['class_name'] ?? 'Object' }}</td>
                                    <td class="px-4 py-2.5">
                                        @if ($isViol)
                                            <span
                                                class="inline-flex rounded-full bg-rose-100 px-2 py-0.5 text-[9px] font-bold text-rose-700 dark:bg-rose-500/10 dark:text-rose-400">Non-Compliant</span>
                                        @elseif ($isPerson)
                                            <span
                                                class="inline-flex rounded-full bg-blue-100 px-2 py-0.5 text-[9px] font-bold text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">Personnel</span>
                                        @else
                                            <span
                                                class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-[9px] font-bold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">Compliant</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2.5 font-mono">
                                        {{ isset($det['confidence']) ? number_format($det['confidence'] * 100, 1) . '%' : '—' }}
                                    </td>
                                    <td class="px-4 py-2.5 font-mono text-slate-500 dark:text-slate-400">
                                        @if (isset($det['bbox']))
                                            [{{ $det['bbox']['x1'] }}, {{ $det['bbox']['y1'] }},
                                            {{ $det['bbox']['x2'] }}, {{ $det['bbox']['y2'] }}]
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

            <!-- Sign-off & Audit Section -->
            <div class="mt-8 border-t border-slate-200 pt-6 dark:border-slate-800 print-break-inside-avoid">
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-slate-400 font-semibold">Investigation
                    Review & Audit Sign-Off</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                    <div>
                        <span class="block text-[9px] uppercase font-bold text-slate-400 mb-2">1. Prepared By</span>
                        <div
                            class="h-10 border-b border-dashed border-slate-300 dark:border-slate-700 flex items-end pb-1">
                            <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">DIKEMAS AI
                                Inspector</span>
                        </div>
                        <span class="block text-[8px] text-slate-400 mt-1">System Automated Report</span>
                    </div>
                    <div>
                        <span class="block text-[9px] uppercase font-bold text-slate-400 mb-2">2. HSE Auditor
                            Sign-off</span>
                        <div class="h-10 border-b border-dashed border-slate-300 dark:border-slate-700"></div>
                        <span class="block text-[8px] text-slate-400 mt-1">Signature & Employee ID</span>
                    </div>
                    <div>
                        <span class="block text-[9px] uppercase font-bold text-slate-400 mb-2">3. Corrective
                            Status</span>
                        <div class="flex flex-col gap-1.5 mt-2">
                            <label class="inline-flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400">
                                <input type="checkbox"
                                    class="rounded border-slate-300 text-amber-500 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800">
                                <span>No Correction Needed</span>
                            </label>
                            <label class="inline-flex items-center gap-1.5 text-xs text-slate-600 dark:text-slate-400">
                                <input type="checkbox"
                                    class="rounded border-slate-300 text-amber-500 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-800">
                                <span>Rectified (Warned/Fined)</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
