<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class StoreViolationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * Decodes the JSON payload string and merges its fields into the request
     * so they can be validated alongside the image file.
     */
    protected function prepareForValidation(): void
    {
        if (! $this->has('payload') || ! is_string($this->input('payload'))) {
            return;
        }

        $decoded = json_decode($this->input('payload'), true);

        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
            return;
        }

        $this->merge($decoded);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,jpg', 'max:'.config('ppe.max_image_size')],
            'payload' => ['required', 'string', 'json'],
            'timestamp' => ['required', 'date'],
            'camera_id' => ['required', 'string', 'max:50'],
            'violation_type' => ['required', Rule::in(config('ppe.violation_types'))],
            'violation_class_id' => ['required', 'integer', Rule::in(config('ppe.violation_class_ids'))],
            'confidence' => ['required', 'numeric', 'between:0,1'],
            'bbox' => ['required', 'array'],
            'bbox.x1' => ['required', 'integer'],
            'bbox.y1' => ['required', 'integer'],
            'bbox.x2' => ['required', 'integer'],
            'bbox.y2' => ['required', 'integer'],
            'person_count' => ['required', 'integer', 'min:0'],
            'all_detections' => ['nullable', 'array'],
            'frame_id' => ['nullable', 'integer'],
            'inference_time_ms' => ['nullable', 'numeric'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * Returns appropriate HTTP status codes based on the type of failure:
     * - 400 for invalid JSON payload
     * - 413 for oversized image
     * - 422 for other validation errors
     */
    protected function failedValidation(Validator $validator): void
    {
        $failedRules = $validator->failed();
        $statusCode = 422;
        $message = 'Validation failed';

        if (isset($failedRules['payload']['Json'])) {
            $statusCode = 400;
            $message = 'Invalid JSON in payload field';
        } elseif (isset($failedRules['image']['Max'])) {
            $statusCode = 413;
            $message = 'Image file size exceeds the allowed limit';
        }

        throw new HttpResponseException(
            new JsonResponse([
                'status' => 'error',
                'message' => $message,
                'errors' => $validator->errors()->toArray(),
            ], $statusCode),
        );
    }
}
