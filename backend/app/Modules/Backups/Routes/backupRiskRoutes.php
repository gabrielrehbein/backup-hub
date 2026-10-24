<?php

use App\Modules\Backups\Http\Controllers\BackupRiskController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/backup-risks/backup/{id}', [BackupRiskController::class, 'findByBackupId']);
});
