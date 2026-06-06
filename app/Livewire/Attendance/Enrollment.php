<?php

namespace App\Livewire\Attendance;

use Livewire\Component;
use App\Models\Employee;
use App\Services\FaceRecognitionService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Enrollment extends Component
{
    public $employee_id = '';
    public $name = '';
    public $photo_base64 = '';
    
    public function save()
    {
        $this->validate([
            'employee_id' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'photo_base64' => 'required|string',
        ]);

        $imageParts = explode(";base64,", $this->photo_base64);
        $imageTypeAux = explode("image/", $imageParts[0]);
        $imageType = $imageTypeAux[1] ?? 'jpg';
        $imageBase64 = base64_decode($imageParts[1]);

        $fileName = 'enrollments/' . Str::slug($this->employee_id) . '-' . time() . '.' . $imageType;
        Storage::disk('public')->put($fileName, $imageBase64);
        
        $absPath = Storage::disk('public')->path($fileName);

        $service = new FaceRecognitionService();
        $res = $service->enroll($this->employee_id, $absPath);

        if (isset($res['success']) && $res['success']) {
            Employee::updateOrCreate(
                ['employee_id' => $this->employee_id],
                [
                    'name' => $this->name,
                    'is_enrolled' => true,
                    'photo_path' => $fileName,
                ]
            );
            
            session()->flash('success', 'Wajah berhasil didaftarkan.');
            return $this->redirectRoute('attendance.index', navigate: true);
        } else {
            session()->flash('error', 'Gagal mendaftar wajah: ' . ($res['message'] ?? 'Unknown error'));
        }
    }

    public function render()
    {
        return view('livewire.attendance.enrollment');
    }
}
