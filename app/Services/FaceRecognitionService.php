<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FaceRecognitionService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.face_recognition.base_url', 'http://localhost:8001');
    }

    public function ping(): bool
    {
        try {
            $response = Http::timeout(3)->get("{$this->baseUrl}/health");

            return $response->successful() && $response->json('status') === 'ok';
        } catch (\Exception $e) {
            Log::error('Face API ping failed: '.$e->getMessage());

            return false;
        }
    }

    public function enroll(string $userId, string $imagePath)
    {
        try {
            $response = Http::attach(
                'image', file_get_contents($imagePath), 'face.jpg'
            )->post("{$this->baseUrl}/api/v1/faces/enroll", [
                'user_id' => $userId,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Face API enroll failed: '.$e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function verify(string $imagePath)
    {
        try {
            $response = Http::attach(
                'image', file_get_contents($imagePath), 'attendance.jpg'
            )->post("{$this->baseUrl}/api/v1/faces/verify");

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Face API verify failed: '.$e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'recognized' => false,
            ];
        }
    }

    public function delete(string $userId)
    {
        try {
            $response = Http::delete("{$this->baseUrl}/api/v1/faces/{$userId}");

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Face API delete failed: '.$e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
