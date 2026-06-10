<?php

namespace App\Livewire;

use App\Models\PpeViolation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public string $cameraFilter = '';

    public string $typeFilter = '';

    #[Computed]
    public function todayCount(): int
    {
        return PpeViolation::today()
            ->when($this->cameraFilter, fn ($q) => $q->byCamera($this->cameraFilter))
            ->when($this->typeFilter, fn ($q) => $q->byType($this->typeFilter))
            ->count();
    }

    #[Computed]
    public function weekCount(): int
    {
        return PpeViolation::thisWeek()
            ->when($this->cameraFilter, fn ($q) => $q->byCamera($this->cameraFilter))
            ->when($this->typeFilter, fn ($q) => $q->byType($this->typeFilter))
            ->count();
    }

    #[Computed]
    public function monthCount(): int
    {
        return PpeViolation::thisMonth()
            ->when($this->cameraFilter, fn ($q) => $q->byCamera($this->cameraFilter))
            ->when($this->typeFilter, fn ($q) => $q->byType($this->typeFilter))
            ->count();
    }

    #[Computed]
    public function averageConfidence(): float
    {
        return round(
            (float) PpeViolation::query()
                ->when($this->cameraFilter, fn ($q) => $q->byCamera($this->cameraFilter))
                ->when($this->typeFilter, fn ($q) => $q->byType($this->typeFilter))
                ->avg('confidence'),
            4,
        );
    }

    #[Computed]
    public function activeCameras(): int
    {
        return PpeViolation::today()->distinct('camera_id')->count('camera_id');
    }

    /**
     * Get violation counts grouped by type for today.
     *
     * @return array<string, int>
     */
    #[Computed]
    public function typeCounts(): array
    {
        $counts = PpeViolation::today()
            ->when($this->cameraFilter, fn ($q) => $q->byCamera($this->cameraFilter))
            ->selectRaw('violation_type, count(*) as total')
            ->groupBy('violation_type')
            ->pluck('total', 'violation_type')
            ->toArray();

        return [
            'NO-Hardhat' => $counts['NO-Hardhat'] ?? 0,
            'NO-Mask' => $counts['NO-Mask'] ?? 0,
            'NO-Safety Vest' => $counts['NO-Safety Vest'] ?? 0,
        ];
    }

    /**
     * Get list of all cameras that have reported violations.
     *
     * @return array<int, string>
     */
    #[Computed]
    public function cameras(): array
    {
        return PpeViolation::distinct()->orderBy('camera_id')->pluck('camera_id')->toArray();
    }

    /**
     * Get violation counts for the last 7 days for charting.
     *
     * @return array<string, array<int, mixed>>
     */
    #[Computed]
    public function chartData(): array
    {
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $days->push(now()->subDays($i)->format('Y-m-d'));
        }

        $counts = PpeViolation::query()
            ->when($this->cameraFilter, fn ($q) => $q->byCamera($this->cameraFilter))
            ->when($this->typeFilter, fn ($q) => $q->byType($this->typeFilter))
            ->where('detected_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(detected_at) as date, count(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $chartDates = [];
        $chartCounts = [];

        foreach ($days as $day) {
            $chartDates[] = Carbon::parse($day)->format('d M');
            $chartCounts[] = $counts->get($day, 0);
        }

        return [
            'categories' => $chartDates,
            'data' => $chartCounts,
        ];
    }

    /**
     * Get recent violations for the live feed table.
     *
     * @return Collection<int, PpeViolation>
     */
    #[Computed]
    public function recentViolations(): Collection
    {
        return PpeViolation::query()
            ->when($this->cameraFilter, fn ($q) => $q->byCamera($this->cameraFilter))
            ->when($this->typeFilter, fn ($q) => $q->byType($this->typeFilter))
            ->latest('detected_at')
            ->limit(10)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.dashboard');
    }
}
