<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreViolationRequest;
use App\Services\ViolationService;
use Illuminate\Http\JsonResponse;

class ViolationController extends Controller
{
    /**
     * Store a new PPE violation from the CCTV detection system.
     */
    public function store(StoreViolationRequest $request, ViolationService $service): JsonResponse
    {
        try {
            $violation = $service->store(
                validatedData: $request->validated(),
                image: $request->file('image'),
                rawPayload: $request->input('payload'),
            );

            return new JsonResponse([
                'status' => 'success',
                'message' => 'Violation recorded successfully',
                'data' => [
                    'id' => $violation->id,
                    'violation_type' => $violation->violation_type,
                    'camera_id' => $violation->camera_id,
                    'created_at' => $violation->created_at->toISOString(),
                ],
            ], 201);
        } catch (\Throwable $e) {
            report($e);

            return new JsonResponse([
                'status' => 'error',
                'message' => 'Failed to record violation: '.$e->getMessage(),
                'errors' => [],
            ], 500);
        }
    }
}
