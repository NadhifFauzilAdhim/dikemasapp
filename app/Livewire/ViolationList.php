<?php

namespace App\Livewire;

use App\Models\PpeViolation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Violations')]
class ViolationList extends Component
{
    use WithPagination;

    #[Url]
    public string $cameraFilter = '';

    #[Url]
    public string $typeFilter = '';

    #[Url]
    public string $dateFrom = '';

    #[Url]
    public string $dateTo = '';

    public float $minConfidence = 0;

    public string $sortField = 'detected_at';

    public string $sortDirection = 'desc';

    public bool $confirmingClearAll = false;

    public function confirmClearAll(): void
    {
        $this->confirmingClearAll = true;
    }

    public function cancelClearAll(): void
    {
        $this->confirmingClearAll = false;
    }

    public function clearAll(): void
    {
        $imagePaths = PpeViolation::whereNotNull('image_path')
            ->pluck('image_path')
            ->filter();

        $disk = config('ppe.storage_disk', 'public');
        foreach ($imagePaths as $path) {
            Storage::disk($disk)->delete($path);
        }

        PpeViolation::query()->delete();

        $this->confirmingClearAll = false;
        $this->resetPage();

        session()->flash('message', 'All violation records and images have been successfully cleared.');
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['cameraFilter', 'typeFilter', 'dateFrom', 'dateTo', 'minConfidence']);
        $this->resetPage();
    }

    public function updatedCameraFilter(): void
    {
        $this->resetPage();
    }

    public function updatedTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function updatedMinConfidence(): void
    {
        $this->resetPage();
    }

    /**
     * @return array<int, string>
     */
    #[Computed]
    public function cameras(): array
    {
        return PpeViolation::distinct()->orderBy('camera_id')->pluck('camera_id')->toArray();
    }

    #[Computed]
    public function violations(): LengthAwarePaginator
    {
        return PpeViolation::query()
            ->when($this->cameraFilter, fn ($q) => $q->byCamera($this->cameraFilter))
            ->when($this->typeFilter, fn ($q) => $q->byType($this->typeFilter))
            ->when($this->dateFrom, fn ($q) => $q->where('detected_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->where('detected_at', '<=', $this->dateTo.' 23:59:59'))
            ->when($this->minConfidence > 0, fn ($q) => $q->minConfidence($this->minConfidence))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);
    }

    public function render(): View
    {
        return view('livewire.violation-list');
    }
}
