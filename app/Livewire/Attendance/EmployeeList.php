<?php

namespace App\Livewire\Attendance;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class EmployeeList extends Component
{
    use WithPagination;

    public $search = '';

    public function removeEnrollment($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        
        if ($employee->is_enrolled) {
            $service = new \App\Services\FaceRecognitionService();
            $service->delete($employee->employee_id);
            
            $employee->update(['is_enrolled' => false, 'photo_path' => null]);
        }
    }

    public function deleteEmployee($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        
        if ($employee->is_enrolled) {
            $service = new \App\Services\FaceRecognitionService();
            $service->delete($employee->employee_id);
            
            if ($employee->photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($employee->photo_path);
            }
        }
        
        $employee->delete();
    }

    public function render()
    {
        $employees = Employee::withCount('attendances')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('employee_id', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.attendance.employee-list', [
            'employees' => $employees,
        ]);
    }
}
