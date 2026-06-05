<?php

use App\Livewire\ViolationHeatmap;
use App\Models\PpeViolation;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('unauthenticated users cannot access heatmap', function () {
    $this->get(route('violations.heatmap'))
        ->assertRedirect(route('login'));
});

test('authenticated users can access heatmap', function () {
    $this->actingAs($this->user)
        ->get(route('violations.heatmap'))
        ->assertOk();
});

test('heatmap extracts center coordinates from bbox', function () {
    PpeViolation::factory()->create([
        'camera_id' => 'CAM-TEST',
        'bbox' => [
            'x1' => 100,
            'y1' => 100,
            'x2' => 200,
            'y2' => 200,
        ],
        'detected_at' => now(),
    ]);

    $this->actingAs($this->user);

    $component = Livewire::test(ViolationHeatmap::class, ['period' => 'today']);

    $points = $component->get('points');

    expect($points)->toBeArray()
        ->and($points)->toHaveCount(1)
        ->and($points[0]['x'])->toBe(150) // (100+200)/2
        ->and($points[0]['y'])->toBe(150) // (100+200)/2
        ->and($points[0]['camera_id'])->toBe('CAM-TEST');
});

test('heatmap filters points by camera id', function () {
    PpeViolation::factory()->create(['camera_id' => 'CAM-A', 'detected_at' => now()]);
    PpeViolation::factory()->create(['camera_id' => 'CAM-B', 'detected_at' => now()]);

    $this->actingAs($this->user);

    $component = Livewire::test(ViolationHeatmap::class, [
        'cameraId' => 'CAM-A',
        'period' => 'today',
    ]);

    $points = $component->get('points');

    expect($points)->toHaveCount(1)
        ->and($points[0]['camera_id'])->toBe('CAM-A');
});
