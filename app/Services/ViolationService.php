<?php

namespace App\Services;

use App\Models\PpeViolation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ViolationService
{
    /**
     * Store a new PPE violation record with its captured image.
     *
     * @param  array<string, mixed>  $validatedData
     */
    public function store(array $validatedData, UploadedFile $image, string $rawPayload): PpeViolation
    {
        return DB::transaction(function () use ($validatedData, $image, $rawPayload): PpeViolation {
            $imagePath = $this->storeImage($image, $validatedData['camera_id']);

            return PpeViolation::create([
                'detected_at' => $validatedData['timestamp'],
                'camera_id' => $validatedData['camera_id'],
                'violation_type' => $validatedData['violation_type'],
                'violation_class_id' => $validatedData['violation_class_id'],
                'confidence' => $validatedData['confidence'],
                'bbox' => $validatedData['bbox'],
                'person_count' => $validatedData['person_count'],
                'all_detections' => $validatedData['all_detections'] ?? null,
                'frame_id' => $validatedData['frame_id'] ?? null,
                'inference_time_ms' => $validatedData['inference_time_ms'] ?? null,
                'image_path' => $imagePath,
                'raw_payload' => json_decode($rawPayload, true),
            ]);
        });
    }

    /**
     * Store the violation capture image with a unique, safe filename.
     */
    protected function storeImage(UploadedFile $image, string $cameraId): string
    {
        $filename = sprintf(
            '%s_%s_%s.jpg',
            Str::slug($cameraId),
            now()->format('Ymd_His'),
            Str::random(8),
        );

        $path = config('ppe.storage_path');
        $disk = config('ppe.storage_disk');

        $image->storeAs($path, $filename, $disk);

        return $path.'/'.$filename;
    }

    /**
     * Delete the violation image from storage.
     */
    public function deleteImage(PpeViolation $violation): bool
    {
        $disk = config('ppe.storage_disk');

        if ($violation->image_path && Storage::disk($disk)->exists($violation->image_path)) {
            return Storage::disk($disk)->delete($violation->image_path);
        }

        return false;
    }
}
