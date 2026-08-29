<?php

namespace App\Modules\Dashboard\Contracts\Services;

use App\Modules\Dashboard\DTOs\MetricsDTO;

interface DashboardServiceInterface
{
    public function getMetrics(): MetricsDTO;
}