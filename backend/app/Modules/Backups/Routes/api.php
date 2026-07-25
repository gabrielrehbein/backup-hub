<?php
use App\Modules\Backups\Http\Controllers\BackupControllerAPI;
use Illuminate\Support\Facades\Route;

Route::get('/health', [BackupControllerAPI::class, 'index']);
