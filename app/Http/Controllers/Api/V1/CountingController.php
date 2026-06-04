<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CountingSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountingController extends Controller
{
    /**
     * Receive a heartbeat from a counting device.
     *
     * Upserts the counting_sessions table based on the authenticated user's token name
     * (used as device_id). This means each API token represents one device/session.
     */
    public function heartbeat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_count' => 'required|integer|min:0',
            'status' => 'required|string|in:started,running,stopped',
            'source_id' => 'nullable|string|max:255',
            'device_id' => 'nullable|string|max:100',
            'timestamp' => 'nullable|string',
            'fps' => 'nullable|numeric|min:0',
            'metadata' => 'nullable|array',
        ]);

        // Use token name as device_id if not explicitly provided.
        $deviceId = $validated['device_id'] ?: $request->user()->currentAccessToken()->name;

        $session = CountingSession::updateOrCreate(
            ['device_id' => $deviceId],
            [
                'source_id' => $validated['source_id'] ?? null,
                'current_count' => $validated['current_count'],
                'status' => $validated['status'],
                'fps' => $validated['fps'] ?? null,
                'last_heartbeat_at' => now(),
                'session_started_at' => $validated['status'] === 'started'
                    ? now()
                    : (CountingSession::where('device_id', $deviceId)->value('session_started_at') ?? now()),
                'metadata' => $validated['metadata'] ?? null,
            ]
        );

        return new JsonResponse([
            'success' => true,
            'message' => 'Heartbeat received.',
            'data' => [
                'id' => $session->id,
                'device_id' => $session->device_id,
                'current_count' => $session->current_count,
                'status' => $session->status,
                'last_heartbeat_at' => $session->last_heartbeat_at?->toISOString(),
            ],
        ]);
    }
}
