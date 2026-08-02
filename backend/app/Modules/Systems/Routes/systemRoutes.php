<?php

use App\Modules\Systems\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/systems', [SystemController::class, 'index']);
Route::post('/systems', [SystemController::class, 'store']);
Route::get('/systems/{id}', [SystemController::class, 'show']);
Route::patch('/systems/{id}', [SystemController::class, 'update']);
Route::delete('/systems/{id}', [SystemController::class, 'destroy']);
