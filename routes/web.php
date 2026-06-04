<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\ApiKeys;
use App\Livewire\Auth\Login;
use App\Livewire\CountingMonitor;
use App\Livewire\Dashboard;
use App\Livewire\ViolationDetail;
use App\Livewire\ViolationList;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/violations', ViolationList::class)->name('violations.index');
    Route::get('/violations/{violation}', ViolationDetail::class)->name('violations.show');
    Route::get('/counting', CountingMonitor::class)->name('counting.index');
    Route::get('/api-keys', ApiKeys::class)->name('api-keys.index');
    Route::post('/logout', LogoutController::class)->name('logout');
});
