<?php

use App\Modules\Auth\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', [AuthController::class, 'login']);
Route::post('/tokens/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
