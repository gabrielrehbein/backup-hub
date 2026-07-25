<?php

use App\Modules\Clients\Http\Controllers\PlanController;

use Illuminate\Support\Facades\Route;

Route::post('plans/', [PlanController::class, 'store']);
Route::get('plans/', [PlanController::class, 'index']);
Route::delete('plans/{id}', [PlanController::class, 'destroy']);
Route::get('plans/{id}', [PlanController::class, 'show']);
Route::patch('plans/{id}', [PlanController::class, 'update']);
