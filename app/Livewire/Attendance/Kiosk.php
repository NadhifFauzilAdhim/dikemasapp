<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\Employee;
use App\Services\FaceRecognitionService;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.blank')]
class Kiosk extends Component
{
    public $pendingAttendance = null;

    #[Computed]
    public function todaysAttendances()
    {
        return Attendance::with('employee')
            ->whereDate('recorded_at', today())
            ->latest('recorded_at')
            ->limit(10)
            ->get();
    }

    public function verify($base64Data)
    {
        $imageParts = explode(';base64,', $base64Data);
        if (count($imageParts) < 2) {
            return;
        }

        $imageTypeAux = explode('image/', $imageParts[0]);
        $imageType = $imageTypeAux[1] ?? 'jpg';
        $imageBase64 = base64_decode($imageParts[1]);

        $fileName = 'attendances/temp-'.time().'.'.$imageType;
        Storage::disk('public')->put($fileName, $imageBase64);
        $absPath = Storage::disk('public')->path($fileName);

        $service = new FaceRecognitionService;
        $res = $service->verify($absPath);

        if (isset($res['success']) && $res['success'] && $res['recognized']) {
            $employee = Employee::where('employee_id', $res['data']['user_id'])->first();

            if ($employee) {
                $todayCount = Attendance::where('employee_id', $employee->id)
                    ->whereDate('recorded_at', today())
                    ->count();

                if ($todayCount >= 2) {
                    Storage::disk('public')->delete($fileName);
                    $this->dispatch('attendance-failed', message: 'Anda sudah absen masuk dan keluar hari ini (Maksimal 2x sehari).');

                    return;
                }

                $determinedType = ($todayCount === 0) ? 'check-in' : 'check-out';

                $this->pendingAttendance = [
                    'employee_id_db' => $employee->id,
                    'employee_id' => $employee->employee_id,
                    'name' => $employee->name,
                    'type' => $determinedType,
                    'confidence' => $res['data']['confidence'],
                    'temp_file' => $fileName,
                    'image_type' => $imageType,
                ];

                $this->dispatch('scan-completed');

                return;
            }
        }

        Storage::disk('public')->delete($fileName);
        $this->dispatch('attendance-failed');
    }

    public function confirmAttendance()
    {
        if (! $this->pendingAttendance) {
            return;
        }

        $p = $this->pendingAttendance;

        $newFileName = 'attendances/'.$p['employee_id'].'-'.time().'.'.$p['image_type'];
        Storage::disk('public')->move($p['temp_file'], $newFileName);

        Attendance::create([
            'employee_id' => $p['employee_id_db'],
            'type' => $p['type'],
            'confidence' => $p['confidence'],
            'photo_path' => $newFileName,
            'recorded_at' => now(),
        ]);

        unset($this->todaysAttendances);

        $this->dispatch('attendance-success', name: $p['name'], type: $p['type']);
        $this->pendingAttendance = null;
    }

    public function cancelAttendance()
    {
        if ($this->pendingAttendance) {
            Storage::disk('public')->delete($this->pendingAttendance['temp_file']);
            $this->pendingAttendance = null;
        }
        $this->dispatch('restart-camera');
    }

    public function render()
    {
        return view('livewire.attendance.kiosk');
    }
}
