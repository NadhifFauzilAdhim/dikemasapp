<?php

use App\Http\Controllers\Api\V1\ViolationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware(['throttle:api'])->group(function (): void {
    Route::post('/violations', [ViolationController::class, 'store'])
        ->middleware('auth:sanctum')
        ->name('api.v1.violations.store');
});
