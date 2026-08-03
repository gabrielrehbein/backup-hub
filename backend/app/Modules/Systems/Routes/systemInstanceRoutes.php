<?php

use App\Modules\Systems\Http\Controllers\SystemInstanceController;
use Illuminate\Support\Facades\Route;


Route::get('/system-instances', [SystemInstanceController::class, 'index']);
Route::post('/system-instances', [SystemInstanceController::class, 'store']);
Route::get('/system-instances/{id}', [SystemInstanceController::class, 'show']);
Route::patch('/system-instances/{id}', [SystemInstanceController::class, 'update']);
Route::delete('/system-instances/{id}', [SystemInstanceController::class, 'destroy']);
