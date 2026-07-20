<?php

use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\ApiAuthController;

Route::post('v1/auth/login', [ApiAuthController::class, 'login'])->name('v1.auth.login');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [ApiAuthController::class, 'logout'])->name('v1.auth.logout');
});
