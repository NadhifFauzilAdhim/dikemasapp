<div>
    @section('title', 'Heatmap Analytics')

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Heatmap Analytics</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Visualisasi titik pelanggaran terbanyak berbasis koordinat kamera (Hotzones).
            </p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <select wire:model.live="period" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                <option value="today">Today</option>
                <option value="this_week">This Week</option>
                <option value="this_month">This Month</option>
                <option value="all_time">All Time</option>
            </select>
            
            <select wire:model.live="cameraId" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                <option value="all">All Cameras</option>
                @foreach ($this->availableCameras as $cam)
                    <option value="{{ $cam }}">{{ $cam }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="flex flex-col xl:flex-row gap-6">
        {{-- Left side: Heatmap --}}
        <div class="flex-grow rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 w-full xl:w-3/4">
            <div class="relative w-full overflow-hidden rounded-xl bg-slate-950 shadow-inner group" 
                 style="height: 600px; @if($this->bgImageUrl) background-image: url('{{ $this->bgImageUrl }}'); background-size: cover; background-position: center; @endif"
                 x-data="heatmapComponent(@js($this->points))"
                 x-init="initCanvas"
                 @resize.window="drawHeatmap"
                 x-effect="points = @js($this->points); drawHeatmap()">
                 
                <!-- Dim overlay for background image to ensure heatmap visibility -->
                @if($this->bgImageUrl)
                    <div class="absolute inset-0 z-0 bg-slate-950/70 transition-opacity group-hover:bg-slate-950/50"></div>
                @endif
                 
                <!-- Canvas Base Grid for Context -->
                <div class="absolute inset-0 z-0" style="background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 50px 50px;"></div>
                <div class="absolute inset-0 z-0 flex items-center justify-center pointer-events-none opacity-20">
                    <svg class="w-32 h-32 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                
                <canvas x-ref="canvas" class="absolute inset-0 z-10 w-full h-full"></canvas>

                <div class="absolute bottom-4 right-4 z-20 flex items-center gap-3 rounded-lg bg-slate-900/80 px-4 py-2 text-xs text-slate-300 backdrop-blur-md border border-slate-700">
                    <div class="flex items-center gap-1.5">
                        <span class="h-3 w-3 rounded-full bg-blue-500 opacity-50 blur-[2px]"></span> Low
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="h-3 w-3 rounded-full bg-amber-500 opacity-80 blur-[2px]"></span> Med
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="h-3 w-3 rounded-full bg-red-500 opacity-100 blur-[2px]"></span> High
                    </div>
                    <div class="ml-2 pl-2 border-l border-slate-600 font-semibold text-white">
                        <span x-text="points.length"></span> violations
                    </div>
                </div>
            </div>
        </div>

        {{-- Right side: Analytics Cards --}}
        <div class="w-full xl:w-1/4 flex flex-col gap-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 flex-1 flex flex-col justify-center">
                <div class="flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400">
                    <svg class="h-5 w-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    Total Violations
                </div>
                <div class="mt-3 text-4xl font-bold text-slate-900 dark:text-white">{{ number_format($this->stats['total']) }}</div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 flex-1 flex flex-col justify-center">
                <div class="flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400">
                    <svg class="h-5 w-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Most Common Type
                </div>
                <div class="mt-3 text-2xl font-bold text-slate-900 dark:text-white truncate">{{ $this->stats['most_common_type'] }}</div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 flex-1 flex flex-col justify-center">
                <div class="flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400">
                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Most Active Camera
                </div>
                <div class="mt-3 text-2xl font-bold text-slate-900 dark:text-white font-mono">{{ $this->stats['most_active_camera'] }}</div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 flex-1 flex flex-col justify-center">
                <div class="flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400">
                    <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Peak Violation Hour
                </div>
                <div class="mt-3 text-2xl font-bold text-slate-900 dark:text-white">{{ $this->stats['peak_hour'] }}</div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('heatmapComponent', (initialPoints) => ({
                points: initialPoints,
                ctx: null,
                initCanvas() {
                    this.ctx = this.$refs.canvas.getContext('2d');
                    this.drawHeatmap();
                },
                drawHeatmap() {
                    if (!this.ctx) return;
                    
                    const canvas = this.$refs.canvas;
                    const rect = canvas.parentElement.getBoundingClientRect();
                    canvas.width = rect.width;
                    canvas.height = rect.height;
                    
                    this.ctx.clearRect(0, 0, canvas.width, canvas.height);
                    
                    if (!this.points || this.points.length === 0) return;

                    let maxX = 1280; 
                    let maxY = 720;
                    
                    const actualMaxX = Math.max(...this.points.map(p => p.x));
                    const actualMaxY = Math.max(...this.points.map(p => p.y));
                    
                    if (actualMaxX > maxX) maxX = actualMaxX;
                    if (actualMaxY > maxY) maxY = actualMaxY;

                    maxX *= 1.1;
                    maxY *= 1.1;

                    // Set composition to create intensity
                    this.ctx.globalCompositeOperation = 'screen';

                    this.points.forEach(point => {
                        const scaledX = (point.x / maxX) * canvas.width;
                        const scaledY = (point.y / maxY) * canvas.height;
                        
                        const radius = 45;
                        const gradient = this.ctx.createRadialGradient(scaledX, scaledY, 0, scaledX, scaledY, radius);
                        
                        gradient.addColorStop(0, 'rgba(239, 68, 68, 0.45)'); 
                        gradient.addColorStop(0.4, 'rgba(245, 158, 11, 0.2)'); 
                        gradient.addColorStop(0.8, 'rgba(59, 130, 246, 0.05)'); 
                        gradient.addColorStop(1, 'rgba(0, 0, 0, 0)'); 
                        
                        this.ctx.beginPath();
                        this.ctx.arc(scaledX, scaledY, radius, 0, 2 * Math.PI);
                        this.ctx.fillStyle = gradient;
                        this.ctx.fill();
                    });
                }
            }));
        });
    </script>
</div>
