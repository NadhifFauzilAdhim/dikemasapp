<?php

namespace Database\Factories;

use App\Models\PpeViolation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PpeViolation>
 */
class PpeViolationFactory extends Factory
{
    protected $model = PpeViolation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $violationTypes = config('ppe.violation_types', ['NO-Hardhat', 'NO-Mask', 'NO-Safety Vest']);
        $classIds = config('ppe.violation_class_ids', [2, 3, 4]);
        $typeIndex = $this->faker->numberBetween(0, count($violationTypes) - 1);

        $x1 = $this->faker->numberBetween(0, 500);
        $y1 = $this->faker->numberBetween(0, 500);

        return [
            'detected_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'camera_id' => 'CAM-'.$this->faker->randomElement(['001', '002', '003', '004', '005']),
            'violation_type' => $violationTypes[$typeIndex],
            'violation_class_id' => $classIds[$typeIndex],
            'confidence' => round($this->faker->randomFloat(4, 0.5, 0.99), 4),
            'bbox' => [
                'x1' => $x1,
                'y1' => $y1,
                'x2' => $x1 + $this->faker->numberBetween(50, 200),
                'y2' => $y1 + $this->faker->numberBetween(100, 300),
            ],
            'person_count' => $this->faker->numberBetween(1, 5),
            'all_detections' => [
                [
                    'class_id' => $classIds[$typeIndex],
                    'class_name' => $violationTypes[$typeIndex],
                    'confidence' => round($this->faker->randomFloat(4, 0.5, 0.99), 4),
                    'bbox' => ['x1' => $x1, 'y1' => $y1, 'x2' => $x1 + 155, 'y2' => $y1 + 289],
                    'area' => $this->faker->numberBetween(10000, 90000),
                    'center' => ['x' => $x1 + 77, 'y' => $y1 + 144],
                ],
            ],
            'frame_id' => $this->faker->numberBetween(1, 5000),
            'inference_time_ms' => round($this->faker->randomFloat(2, 10, 50), 2),
            'image_path' => 'ppe-violations/test_'.$this->faker->uuid().'.jpg',
            'raw_payload' => [
                'timestamp' => now()->toISOString(),
                'camera_id' => 'CAM-001',
            ],
        ];
    }
}
