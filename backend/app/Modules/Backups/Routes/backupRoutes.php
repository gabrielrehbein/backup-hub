<?php

use App\Modules\Backups\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

Route::post('/backups', [BackupController::class, 'store'])->middleware('instance.auth');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/backups', [BackupController::class, 'index']);
    Route::get('/backups/{id}', [BackupController::class, 'show']);
    Route::get('/backups/instances/latest', [BackupController::class, 'lastBackupsByInstances']);
});

Route::post('/backups/test-risk', [BackupController::class, 'testRisk']);
