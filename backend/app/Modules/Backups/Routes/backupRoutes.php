<?php

use App\Modules\Backups\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

Route::post('/backups', [BackupController::class, 'store'])->middleware('client.auth');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/backups', [BackupController::class, 'index']);
    Route::get('/backups/{id}', [BackupController::class, 'show']);
});

Route::post('/backups/test-risk', [BackupController::class, 'testRisk']);