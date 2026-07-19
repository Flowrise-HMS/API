<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Controllers\ApiAuthController;
use Modules\Core\Http\Responses\ApiResponse;

Route::post('v1/auth/login', [ApiAuthController::class, 'login'])->name('v1.auth.login');

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    /**
     * @group Authentication
     */
    Route::post('auth/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::ok(['message' => 'Logged out successfully.']);
    })->name('v1.auth.logout');
});
