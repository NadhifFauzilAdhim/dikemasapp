<x-slot:title>Pendaftaran Wajah</x-slot:title>

<div class="mx-auto max-w-3xl space-y-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white/80 p-5 shadow-sm backdrop-blur-md dark:border-slate-800/80 dark:bg-slate-900/80">
        <!-- Ambient Glow Decoration inside Card -->
        <div class="absolute -left-12 -top-12 h-24 w-24 rounded-full bg-amber-500/10 blur-xl dark:bg-amber-500/5"></div>
        
        <div class="relative z-10 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-4">
                <a wire:navigate href="{{ route('attendance.index') }}" class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600 transition-colors hover:bg-slate-200 hover:text-slate-950 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Pendaftaran Wajah Baru</h1>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Daftarkan wajah karyawan baru ke sistem absensi deteksi wajah.</p>
                </div>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700 dark:bg-red-500/10 dark:text-red-400">
            {{ session('error') }}
        </div>
    @endif

    <style>
        @keyframes scan {
            0%, 100% { top: 8%; opacity: 0.8; }
            50% { top: 88%; opacity: 0.8; }
        }
        .animate-scan {
            position: absolute;
            animation: scan 2.5s ease-in-out infinite;
        }
    </style>

    <div class="relative overflow-hidden rounded-xl border border-slate-200/80 bg-white/80 p-6 shadow-md backdrop-blur-md dark:border-slate-800/80 dark:bg-slate-900/80"
        x-data="{ 
            stream: null,
            isCapturing: true,
            photoData: @entangle('photo_base64'),
            
            initCamera() {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(s => {
                        this.stream = s;
                        this.$refs.video.srcObject = s;
                        this.$refs.video.play();
                    })
                    .catch(err => {
                        alert('Tidak dapat mengakses kamera: ' + err.message);
                    });
            },
            capture() {
                const canvas = document.createElement('canvas');
                canvas.width = this.$refs.video.videoWidth;
                canvas.height = this.$refs.video.videoHeight;
                canvas.getContext('2d').drawImage(this.$refs.video, 0, 0);
                this.photoData = canvas.toDataURL('image/jpeg');
                this.isCapturing = false;
                
                if(this.stream) {
                    this.stream.getTracks().forEach(t => t.stop());
                }
            },
            retake() {
                this.photoData = '';
                this.isCapturing = true;
                this.initCamera();
            }
        }"
        x-init="initCamera()"
    >
        <!-- Card background glow decoration -->
        <div class="absolute -right-12 -top-12 h-24 w-24 rounded-full bg-amber-500/10 blur-xl dark:bg-amber-500/5"></div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-4">
                <div class="relative overflow-hidden rounded-lg bg-black aspect-[4/3] flex items-center justify-center border border-slate-300 dark:border-slate-800">
                    <video x-ref="video" class="h-full w-full object-cover transform scale-x-[-1]" x-show="isCapturing"></video>
                    <img :src="photoData" class="h-full w-full object-cover transform scale-x-[-1]" x-show="!isCapturing" />
                    
                    <!-- HUD Target Brackets (Camera viewport overlay) -->
                    <div x-show="isCapturing" class="absolute inset-4 border border-dashed border-white/20 pointer-events-none rounded-md"></div>
                    <div x-show="isCapturing" class="absolute top-6 left-6 h-6 w-6 border-t-2 border-l-2 border-amber-500 pointer-events-none"></div>
                    <div x-show="isCapturing" class="absolute top-6 right-6 h-6 w-6 border-t-2 border-r-2 border-amber-500 pointer-events-none"></div>
                    <div x-show="isCapturing" class="absolute bottom-6 left-6 h-6 w-6 border-b-2 border-l-2 border-amber-500 pointer-events-none"></div>
                    <div x-show="isCapturing" class="absolute bottom-6 right-6 h-6 w-6 border-b-2 border-r-2 border-amber-500 pointer-events-none"></div>
                    
                    <!-- HUD Scan Line Animation -->
                    <div x-show="isCapturing" class="animate-scan left-4 right-4 h-0.5 bg-gradient-to-r from-transparent via-amber-500 to-transparent shadow-[0_0_8px_#f59e0b] pointer-events-none"></div>
                    
                    <!-- HUD Status Badge -->
                    <div x-show="isCapturing" class="absolute top-6 left-1/2 -translate-x-1/2 rounded bg-black/60 px-2.5 py-1 text-[10px] font-mono tracking-widest text-amber-500 border border-amber-500/20 backdrop-blur-sm pointer-events-none flex items-center gap-1.5 uppercase">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-ping"></span>
                        Ready to Scan
                    </div>
                    
                    <div x-show="isCapturing" class="absolute bottom-4 left-0 right-0 flex justify-center">
                        <button type="button" @click="capture()" class="rounded-full bg-amber-500 p-4 text-white shadow-lg hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-500/50">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </button>
                    </div>
                </div>
                <button type="button" @click="retake()" x-show="!isCapturing" class="w-full rounded-lg border border-slate-300 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                    Ulangi Foto
                </button>
            </div>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">NIK / ID Karyawan</label>
                    <input type="text" wire:model="employee_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
                    @error('employee_id') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" required>
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="w-full rounded-lg bg-amber-500 py-2.5 text-sm font-semibold text-white hover:bg-amber-600 focus:outline-none focus:ring-4 focus:ring-amber-500/50 disabled:opacity-50" wire:loading.attr="disabled" :disabled="!photoData">
                        <span wire:loading.remove>Simpan & Daftarkan Wajah</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
