<?php

namespace App\Modules\Dashboard\Http\Controllers;


use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Http\Request;
use App\Modules\Dashboard\Contracts\Services\DashboardServiceInterface;

class DashboardController
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
    ){}

    public function getMetrics(Request $request)
    {
        $data = $this->dashboardService->getMetrics();
        return JSONResponse::success($data, "Dashboard recuperado com sucesso.");
    }
}
