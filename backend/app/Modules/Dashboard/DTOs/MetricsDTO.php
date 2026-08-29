<?php

namespace App\Modules\Dashboard\DTOs;

final readonly class MetricsDTO
{
    public function __construct(
        public array $summary,
        public array $riskDistribution,
        public array $riskByType,
        public array $recentBackups,
        public array $backupsGeneratedToday,
        public array $clientsWithMostBackupRiskByPlan,
    ) {}
}