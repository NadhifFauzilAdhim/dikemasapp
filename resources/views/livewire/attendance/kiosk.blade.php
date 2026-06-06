<div class="flex min-h-screen flex-col bg-slate-50 p-4 font-sans text-slate-900 md:flex-row" x-data="{
    stream: null,
    isProcessing: false,
    message: '',
    messageType: '',

    initCamera() {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(s => {
                this.stream = s;
                this.$refs.video.srcObject = s;
                this.$refs.video.play();
            })
            .catch(err => {
                this.showMessage('Kamera tidak ditemukan!', 'error');
            });
    },
    scan() {
        if (this.isProcessing) return;
        this.isProcessing = true;

        const canvas = document.createElement('canvas');
        canvas.width = this.$refs.video.videoWidth;
        canvas.height = this.$refs.video.videoHeight;
        canvas.getContext('2d').drawImage(this.$refs.video, 0, 0);

        $wire.verify(canvas.toDataURL('image/jpeg'));
    },
    showMessage(msg, type) {
        this.message = msg;
        this.messageType = type;
        setTimeout(() => {
            this.message = '';
        }, 3000);
    }
}"
    x-init="initCamera()"
    @attendance-success.window="isProcessing = false; showMessage(`Berhasil ${$event.detail.type === 'check-in' ? 'Masuk' : 'Keluar'}: ` + $event.detail.name, 'success')"
    @attendance-failed.window="isProcessing = false; showMessage($event.detail.message ? $event.detail.message : 'Wajah tidak dikenali atau belum terdaftar!', 'error')">
    <!-- Left Section: Scanner -->
    <div class="flex w-full flex-col items-center justify-center p-6 md:w-2/3 lg:w-3/4">
        <div class="mb-8 text-center">
            <img src="{{ asset('image/logo-header.png') }}" alt="Dikemas Ops Logo"
                class="mx-auto mb-4 h-16 w-auto object-contain drop-shadow-sm">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-800">Absensi Karyawan</h1>
            <p class="mt-2 text-sm text-slate-500">Pindai wajah Anda untuk mencatat kehadiran hari ini</p>
        </div>

        <div
            class="relative mx-auto aspect-[4/3] w-full max-w-lg overflow-hidden rounded-3xl border-8 border-white bg-black shadow-2xl shadow-slate-200">
            <video x-ref="video" class="h-full w-full object-cover transform scale-x-[-1]"></video>

            <div x-show="isProcessing"
                class="absolute inset-0 flex items-center justify-center bg-white/60 backdrop-blur-sm">
                <div class="h-16 w-16 animate-spin rounded-full border-4 border-amber-500 border-t-transparent"></div>
            </div>

            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="h-64 w-64 rounded-3xl border-2 border-dashed border-white/70 shadow-sm"></div>
            </div>
        </div>

        <div class="mt-8">
            <button @click="scan()" :disabled="isProcessing"
                class="rounded-full bg-blue-600 px-14 py-4 text-2xl font-black tracking-widest text-white shadow-xl shadow-blue-600/30 transition-all hover:-translate-y-1 hover:bg-blue-700 active:translate-y-0 disabled:opacity-50 focus:outline-none focus:ring-4 focus:ring-blue-500">
                TAP TO SCAN
            </button>
        </div>
    </div>

    <!-- Popup Notification Modal -->
    <div x-show="message" x-transition.opacity.duration.300ms 
        class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" style="display: none;">
        <div x-show="message" x-transition.scale.90.duration.300ms @click.outside="message = ''"
            class="mx-4 flex w-full max-w-sm flex-col items-center justify-center rounded-3xl bg-white p-10 text-center shadow-2xl">
            
            <div x-show="messageType === 'success'" class="mb-5 flex h-24 w-24 items-center justify-center rounded-full bg-emerald-100 text-emerald-500 shadow-inner">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            
            <div x-show="messageType === 'error'" class="mb-5 flex h-24 w-24 items-center justify-center rounded-full bg-red-100 text-red-500 shadow-inner">
                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>

            <h3 class="mb-3 text-3xl font-extrabold text-slate-800" 
                x-text="messageType === 'success' ? 'Berhasil!' : 'Gagal!'"></h3>
            <p class="text-lg font-medium text-slate-600" x-text="message"></p>
        </div>
    </div>

    <!-- Right Section: Today's Attendees -->
    <div class="w-full border-l border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/50 md:w-1/3 lg:w-1/4">
        <h2 class="mb-6 flex items-center gap-2 text-xl font-bold text-slate-800">
            <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Kehadiran Hari Ini
        </h2>

        <div class="space-y-4">
            @forelse($this->todaysAttendances as $attendance)
                <div
                    class="flex items-center gap-4 rounded-xl border border-slate-100 bg-slate-50 p-3 transition hover:border-slate-200 hover:bg-white hover:shadow-sm">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-200 text-sm font-bold text-slate-600">
                        {{ strtoupper(substr($attendance->employee->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold text-slate-800">{{ $attendance->employee->name }}</p>
                        <p class="text-xs text-slate-500">{{ $attendance->recorded_at->format('H:i:s') }}</p>
                    </div>
                    <div>
                        @if ($attendance->type === 'check-in')
                            <span
                                class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Masuk</span>
                        @else
                            <span
                                class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Keluar</span>
                        @endif
                    </div>
                </div>
            @empty
                <div
                    class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-200 py-12 text-center text-slate-400">
                    <svg class="mb-2 h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <p class="text-sm font-medium">Belum ada data kehadiran.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
