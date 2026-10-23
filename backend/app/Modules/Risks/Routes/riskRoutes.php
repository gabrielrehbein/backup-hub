<?php

use App\Modules\Risks\Http\Controllers\RiskController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {
    Route::get('risks/', [RiskController::class, 'index']);
    Route::get('risks/plans/{planId}', [RiskController::class, 'listByPlan']);
    Route::get('risks/{id}', [RiskController::class, 'show']);
    Route::post('risks/', [RiskController::class, 'store']);
    Route::patch('risks/{id}', [RiskController::class, 'update']);
    Route::delete('risks/{id}', [RiskController::class, 'destroy']);
});
