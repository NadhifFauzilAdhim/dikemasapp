<?php

namespace App\Models;

use Database\Factories\PpeViolationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'detected_at',
    'camera_id',
    'violation_type',
    'violation_class_id',
    'confidence',
    'bbox',
    'person_count',
    'all_detections',
    'frame_id',
    'inference_time_ms',
    'image_path',
    'raw_payload',
])]
class PpeViolation extends Model
{
    /** @use HasFactory<PpeViolationFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'detected_at' => 'datetime',
            'confidence' => 'float',
            'inference_time_ms' => 'float',
            'bbox' => 'array',
            'all_detections' => 'array',
            'raw_payload' => 'array',
        ];
    }

    /**
     * Get the public URL for the violation image.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return Storage::disk(config('ppe.storage_disk'))->url($this->image_path);
    }

    /**
     * Scope violations detected today.
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('detected_at', today());
    }

    /**
     * Scope violations detected this week.
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('detected_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope violations detected this month.
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('detected_at', now()->month)
            ->whereYear('detected_at', now()->year);
    }

    /**
     * Scope violations by camera ID.
     */
    public function scopeByCamera(Builder $query, string $cameraId): Builder
    {
        return $query->where('camera_id', $cameraId);
    }

    /**
     * Scope violations by type.
     */
    public function scopeByType(Builder $query, string $violationType): Builder
    {
        return $query->where('violation_type', $violationType);
    }

    /**
     * Scope violations with minimum confidence threshold.
     */
    public function scopeMinConfidence(Builder $query, float $confidence): Builder
    {
        return $query->where('confidence', '>=', $confidence);
    }
}
