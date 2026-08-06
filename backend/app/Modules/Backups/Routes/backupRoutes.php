<?php

use App\Modules\Backups\Http\Controllers\BackupController;
use Illuminate\Support\Facades\Route;

Route::post('/backups', [BackupController::class, 'store']);
Route::get('/backups', [BackupController::class, 'index']);
Route::get('/backups/{id}', [BackupController::class, 'show']);
