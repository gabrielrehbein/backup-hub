<?php

use App\Modules\Systems\Http\Controllers\SystemInstanceController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::patch('instances/{id}/api-key/refresh', [SystemInstanceController::class, 'refreshApiKey']);
    Route::get('/instances', [SystemInstanceController::class, 'index']);
    Route::post('/instances', [SystemInstanceController::class, 'store']);
    Route::get('/instances/{id}', [SystemInstanceController::class, 'show']);
    Route::patch('/instances/{id}', [SystemInstanceController::class, 'update']);
    Route::delete('/instances/{id}', [SystemInstanceController::class, 'destroy']);
});
