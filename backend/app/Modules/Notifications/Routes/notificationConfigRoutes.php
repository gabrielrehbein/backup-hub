<?php

use App\Modules\Dashboard\Http\Controllers\DashboardController;
use App\Modules\Notifications\Http\Controllers\NotificationConfigController;
use App\Modules\Notifications\Services\NotificationConfigService;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::put('/notification-config', [NotificationConfigController::class, 'save']);
});
