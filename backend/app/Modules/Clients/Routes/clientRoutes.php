<?php

use App\Modules\Clients\Http\Controllers\ClientController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('clients/', [ClientController::class, 'store']);
    Route::get('clients/', [ClientController::class, 'index']);
    Route::delete('clients/{id}', [ClientController::class, 'destroy']);
    Route::get('clients/{id}', [ClientController::class, 'show']);
    Route::patch('clients/{id}', [ClientController::class, 'update']);
});
