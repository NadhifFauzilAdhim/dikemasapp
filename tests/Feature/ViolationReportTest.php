<?php

use App\Models\PpeViolation;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->violation = PpeViolation::factory()->create([
        'violation_type' => 'NO-Hardhat',
        'camera_id' => 'CAM-TEST',
        'raw_payload' => [
            'camera_width' => 1280,
            'camera_height' => 720,
            'person_count' => 2,
            'inference_time_ms' => 15.6,
        ],
    ]);
});

test('unauthenticated users are redirected to login', function () {
    $this->get(route('violations.report', $this->violation))
        ->assertRedirect(route('login'));
});

test('authenticated users can access the violation report page', function () {
    $this->actingAs($this->user)
        ->get(route('violations.report', $this->violation))
        ->assertOk()
        ->assertViewIs('violations.report')
        ->assertSee('HSE Incident Investigation Report')
        ->assertSee('CAM-TEST')
        ->assertSee('NO-Hardhat');
});
