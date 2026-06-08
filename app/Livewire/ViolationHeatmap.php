<?php

namespace App\Livewire;

use App\Models\PpeViolation;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Heatmap Analytics')]
class ViolationHeatmap extends Component
{
    #[Url]
    public string $cameraId = 'all';

    #[Url]
    public string $period = 'this_month';

    public function getPointsProperty(): array
    {
        $query = PpeViolation::query()
            ->select(['id', 'camera_id', 'bbox', 'detected_at']);

        if ($this->cameraId !== 'all') {
            $query->where('camera_id', $this->cameraId);
        }

        if ($this->period === 'today') {
            $query->whereDate('detected_at', Carbon::today());
        } elseif ($this->period === 'this_week') {
            $query->whereBetween('detected_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->period === 'this_month') {
            $query->whereMonth('detected_at', Carbon::now()->month)
                ->whereYear('detected_at', Carbon::now()->year);
        } elseif ($this->period === 'all_time') {
            // no date filter
        }

        $violations = $query->get();

        $points = [];
        foreach ($violations as $v) {
            $bbox = $v->bbox;
            if (is_array($bbox) && isset($bbox['x1'], $bbox['x2'], $bbox['y1'], $bbox['y2'])) {
                $cx = ($bbox['x1'] + $bbox['x2']) / 2;
                $cy = ($bbox['y1'] + $bbox['y2']) / 2;
                $points[] = ['x' => $cx, 'y' => $cy, 'camera_id' => $v->camera_id];
            }
        }

        return $points;
    }

    public function getAvailableCamerasProperty(): array
    {
        return PpeViolation::select('camera_id')->distinct()->pluck('camera_id')->filter()->values()->toArray();
    }

    public function getCameraDimensionsProperty(): array
    {
        $query = PpeViolation::query()->whereNotNull('raw_payload');

        if ($this->cameraId !== 'all') {
            $query->where('camera_id', $this->cameraId);
        }

        $latest = $query->latest('detected_at')->first(['raw_payload']);

        $width = 1280;
        $height = 720;

        if ($latest && is_array($latest->raw_payload)) {
            $payload = $latest->raw_payload;
            if (isset($payload['camera_width']) && $payload['camera_width'] > 0) {
                $width = (int) $payload['camera_width'];
            }
            if (isset($payload['camera_height']) && $payload['camera_height'] > 0) {
                $height = (int) $payload['camera_height'];
            }
        }

        return ['width' => $width, 'height' => $height];
    }

    public function getBgImageUrlProperty(): ?string
    {
        $query = PpeViolation::query()->whereNotNull('image_path')->latest('detected_at');
        if ($this->cameraId !== 'all') {
            $query->where('camera_id', $this->cameraId);
        }
        $latest = $query->first();

        return $latest ? $latest->imageUrl : null;
    }

    public function getStatsProperty(): array
    {
        $query = PpeViolation::query();

        if ($this->cameraId !== 'all') {
            $query->where('camera_id', $this->cameraId);
        }

        if ($this->period === 'today') {
            $query->whereDate('detected_at', Carbon::today());
        } elseif ($this->period === 'this_week') {
            $query->whereBetween('detected_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->period === 'this_month') {
            $query->whereMonth('detected_at', Carbon::now()->month)
                ->whereYear('detected_at', Carbon::now()->year);
        }

        $violations = $query->get(['id', 'camera_id', 'violation_type', 'detected_at']);

        if ($violations->isEmpty()) {
            return [
                'total' => 0,
                'most_common_type' => '—',
                'most_active_camera' => '—',
                'peak_hour' => '—',
            ];
        }

        $types = $violations->groupBy('violation_type')->map->count()->sortDesc();
        $cameras = $violations->groupBy('camera_id')->map->count()->sortDesc();

        $hours = $violations->groupBy(function ($val) {
            return $val->detected_at->format('H');
        })->map->count()->sortDesc();

        $peakHourStr = '—';
        if ($hours->isNotEmpty()) {
            $peakH = $hours->keys()->first();
            $peakHourStr = $peakH.':00 - '.str_pad($peakH + 1, 2, '0', STR_PAD_LEFT).':00';
        }

        return [
            'total' => $violations->count(),
            'most_common_type' => $types->keys()->first() ?? '—',
            'most_active_camera' => $cameras->keys()->first() ?? '—',
            'peak_hour' => $peakHourStr,
        ];
    }

    public function render(): View
    {
        return view('livewire.violation-heatmap');
    }
}
