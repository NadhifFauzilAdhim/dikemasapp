<x-slot:title>Daftar Karyawan</x-slot:title>

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Daftar Karyawan</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Kelola karyawan dan status absensi wajah.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari NIK / Nama..."
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-1 focus:ring-amber-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white" />
            <a wire:navigate href="{{ route('attendance.enroll') }}"
                class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                Daftar Wajah
            </a>
            <a href="{{ route('attendance.kiosk') }}" target="_blank"
                class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:ring-offset-2">
                Buka Kiosk
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
                <thead class="bg-slate-50 text-xs uppercase text-slate-700 dark:bg-slate-800/50 dark:text-slate-300">
                    <tr>
                        <th class="px-6 py-4 font-medium">NIK</th>
                        <th class="px-6 py-4 font-medium">Nama</th>
                        <th class="px-6 py-4 font-medium">Status Enrollment</th>
                        <th class="px-6 py-4 font-medium">Total Absen</th>
                        <th class="px-6 py-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/25">
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $emp->employee_id }}</td>
                        <td class="px-6 py-4">{{ $emp->name }}</td>
                        <td class="px-6 py-4">
                            @if($emp->is_enrolled)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Terdaftar
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                    Belum Terdaftar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $emp->attendances_count }} kali</td>
                        <td class="px-6 py-4 text-right">
                            @if($emp->is_enrolled)
                                <button wire:click="removeEnrollment({{ $emp->id }})" wire:confirm="Yakin ingin menghapus data wajah ini?"
                                    class="text-amber-500 hover:text-amber-700 dark:hover:text-amber-400">
                                    Hapus Wajah
                                </button>
                            @endif
                            <button wire:click="deleteEmployee({{ $emp->id }})" wire:confirm="Yakin ingin menghapus karyawan ini beserta semua riwayat absensinya?"
                                class="ml-3 text-red-500 hover:text-red-700 dark:hover:text-red-400">
                                Hapus Karyawan
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            Belum ada data karyawan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($employees->hasPages())
        <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-800">
            {{ $employees->links() }}
        </div>
        @endif
    </div>
</div>
