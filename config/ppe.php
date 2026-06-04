<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Key Authentication
    |--------------------------------------------------------------------------
    |
    | API key used to authenticate requests from CCTV detection systems.
    | If left empty, the endpoint will accept requests without authentication.
    |
    */

    'api_key' => env('PPE_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Image Upload Settings
    |--------------------------------------------------------------------------
    |
    | Maximum image size in kilobytes and storage configuration for
    | violation capture images.
    |
    */

    'max_image_size' => (int) env('PPE_MAX_IMAGE_SIZE_KB', 5120),

    'storage_disk' => env('PPE_STORAGE_DISK', 'public'),

    'storage_path' => env('PPE_STORAGE_PATH', 'ppe-violations'),

    /*
    |--------------------------------------------------------------------------
    | Violation Types & Class IDs
    |--------------------------------------------------------------------------
    |
    | Allowed violation types and their corresponding class IDs from the
    | CCTV detection model.
    |
    */

    'violation_types' => [
        'NO-Hardhat',
        'NO-Mask',
        'NO-Safety Vest',
    ],

    'violation_class_ids' => [2, 3, 4],

];
