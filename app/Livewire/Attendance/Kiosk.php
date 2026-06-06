<?php

namespace App\Livewire\Attendance;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Attendance;
use App\Services\FaceRecognitionService;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.blank')]
class Kiosk extends Component
{
    #[\Livewire\Attributes\Computed]
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
        $imageParts = explode(";base64,", $base64Data);
        if (count($imageParts) < 2) return;
        
        $imageTypeAux = explode("image/", $imageParts[0]);
        $imageType = $imageTypeAux[1] ?? 'jpg';
        $imageBase64 = base64_decode($imageParts[1]);

        $fileName = 'attendances/temp-' . time() . '.' . $imageType;
        Storage::disk('public')->put($fileName, $imageBase64);
        $absPath = Storage::disk('public')->path($fileName);

        $service = new FaceRecognitionService();
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

                $newFileName = 'attendances/' . $employee->employee_id . '-' . time() . '.' . $imageType;
                Storage::disk('public')->move($fileName, $newFileName);
                
                Attendance::create([
                    'employee_id' => $employee->id,
                    'type' => $determinedType,
                    'confidence' => $res['data']['confidence'],
                    'photo_path' => $newFileName,
                    'recorded_at' => now(),
                ]);
                
                unset($this->todaysAttendances);
                
                $this->dispatch('attendance-success', name: $employee->name, type: $determinedType);
                return;
            }
        }
        
        Storage::disk('public')->delete($fileName);
        $this->dispatch('attendance-failed');
    }

    public function render()
    {
        return view('livewire.attendance.kiosk');
    }
}
