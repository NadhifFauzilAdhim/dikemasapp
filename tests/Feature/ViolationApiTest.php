<?php

use App\Models\PpeViolation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

$testUser = null;
$testBearerToken = null;

beforeEach(function () use (&$testUser, &$testBearerToken): void {
    Storage::fake('public');

    $testUser = User::factory()->create();
    $token = $testUser->createToken('test-token');
    $testBearerToken = $token->plainTextToken;
});

function makeValidPayload(array $overrides = []): string
{
    return json_encode(array_merge([
        'timestamp' => '2026-06-03T22:15:30.123456',
        'camera_id' => 'CAM-001',
        'violation_type' => 'NO-Hardhat',
        'violation_class_id' => 2,
        'confidence' => 0.8723,
        'bbox' => ['x1' => 234, 'y1' => 156, 'x2' => 389, 'y2' => 445],
        'person_count' => 3,
        'all_detections' => [
            [
                'class_id' => 2,
                'class_name' => 'NO-Hardhat',
                'confidence' => 0.8723,
                'bbox' => ['x1' => 234, 'y1' => 156, 'x2' => 389, 'y2' => 445],
                'area' => 44805,
                'center' => ['x' => 311, 'y' => 300],
            ],
        ],
        'frame_id' => 1520,
        'inference_time_ms' => 23.45,
    ], $overrides));
}

it('successfully creates a violation with valid data', function () use (&$testBearerToken): void {
    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg', 640, 480),
        'payload' => makeValidPayload(),
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $response->assertStatus(201)
        ->assertJson([
            'status' => 'success',
            'message' => 'Violation recorded successfully',
        ])
        ->assertJsonStructure([
            'data' => ['id', 'violation_type', 'camera_id', 'created_at'],
        ]);
});

it('persists the violation to the database', function () use (&$testBearerToken): void {
    $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg', 640, 480),
        'payload' => makeValidPayload(),
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $this->assertDatabaseCount('ppe_violations', 1);
    $this->assertDatabaseHas('ppe_violations', [
        'camera_id' => 'CAM-001',
        'violation_type' => 'NO-Hardhat',
        'violation_class_id' => 2,
        'person_count' => 3,
    ]);
});

it('stores the image to the public disk', function () use (&$testBearerToken): void {
    $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg', 640, 480),
        'payload' => makeValidPayload(),
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $violation = PpeViolation::first();

    Storage::disk('public')->assertExists($violation->image_path);
});

it('fails without an image', function () use (&$testBearerToken): void {
    $response = $this->postJson('/api/v1/violations', [
        'payload' => makeValidPayload(),
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $response->assertStatus(422)
        ->assertJson(['status' => 'error'])
        ->assertJsonValidationErrors(['image']);
});

it('fails with invalid JSON payload', function () use (&$testBearerToken): void {
    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg'),
        'payload' => 'not-valid-json{{{',
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $response->assertStatus(400)
        ->assertJson([
            'status' => 'error',
            'message' => 'Invalid JSON in payload field',
        ]);
});

it('fails with invalid violation type', function () use (&$testBearerToken): void {
    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg'),
        'payload' => makeValidPayload(['violation_type' => 'INVALID-TYPE']),
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['violation_type']);
});

it('fails with invalid violation class id', function () use (&$testBearerToken): void {
    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg'),
        'payload' => makeValidPayload(['violation_class_id' => 99]),
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['violation_class_id']);
});

it('fails with confidence out of range', function () use (&$testBearerToken): void {
    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg'),
        'payload' => makeValidPayload(['confidence' => 1.5]),
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['confidence']);
});

it('fails with missing or invalid Authorization header', function (): void {
    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg'),
        'payload' => makeValidPayload(),
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
});

it('fails with wrong API key', function (): void {
    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg'),
        'payload' => makeValidPayload(),
    ], [
        'Authorization' => 'Bearer wrong-key',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'message' => 'Unauthenticated.',
        ]);
});

it('allows requests with correct API key and updates last_used_at', function (): void {
    $user = User::factory()->create();
    $token = $user->createToken('Test Camera');
    $plainTextToken = $token->plainTextToken;

    $this->assertNull($token->accessToken->last_used_at);

    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg'),
        'payload' => makeValidPayload(),
    ], [
        'Authorization' => 'Bearer '.$plainTextToken,
    ]);

    $response->assertStatus(201);

    $token->accessToken->refresh();
    $this->assertNotNull($token->accessToken->last_used_at);
});

it('fails without missing required payload fields', function () use (&$testBearerToken): void {
    $response = $this->postJson('/api/v1/violations', [
        'image' => UploadedFile::fake()->image('capture.jpg'),
        'payload' => json_encode(['camera_id' => 'CAM-001']),
    ], ['Authorization' => 'Bearer '.$testBearerToken]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['timestamp', 'violation_type', 'confidence', 'bbox', 'person_count']);
});
