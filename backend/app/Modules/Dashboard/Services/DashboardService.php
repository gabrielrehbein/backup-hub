<?php

namespace App\Modules\Dashboard\Services;


use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Backups\Http\Resources\LastBackupsResource;
use App\Modules\Dashboard\Contracts\Services\DashboardServiceInterface;
use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\Models\Backup;
use App\Modules\Clients\Contracts\Repositories\PlanRepositoryInterface;
use App\Modules\Dashboard\DTOs\MetricsDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardService implements DashboardServiceInterface {

    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly BackupServiceInterface $backupService,
        private readonly BackupRiskServiceInterface $backupRiskService,
        private readonly PlanRepositoryInterface $planRepository
    ) {}


    public function getMetrics(): MetricsDTO
    {
        return new MetricsDTO(
            summary: $this->getSummary(),
            riskDistribution: $this->getRiskDistribution(),
            riskByType: $this->getRiskByType(),
            recentBackups: $this->getRecentBackups(),
            backupsGeneratedToday: $this->getBackupsGeneratedToday(),
            clientsWithMostBackupRiskByPlan: $this->getClientsWithMostBackupRiskByPlan(),
        );
    }

    private function getSummary(): array
    {
        return [
            'total_clients' => $this->clientService->getTotalClients(),
            'total_backups' => $this->backupService->getTotalBackups(),
            'risk_backups' => $this->backupService->getTotalBackupsWithRisk(),
        ];
    }

    private function getRiskDistribution(): array
    {
        return [
            $this->backupRiskService->getTotalRisk(),
            $this->backupRiskService->getTotalRisk('Baixo'),
            $this->backupRiskService->getTotalRisk('Medio'),
            $this->backupRiskService->getTotalRisk('Alto'),
        ];
    }

    private function getRiskByType(): array
    {
        return $this->backupRiskService->getTotalBackupRisksByType();
    }

    private function getRecentBackups(int $limit = 10): array
    {
        return [
            'local' => LastBackupsResource::collection($this->backupService->findLastBackups($limit, true)),
            'remote' => LastBackupsResource::collection($this->backupService->findLastBackups($limit, false)),
        ];
    }

    private function getBackupsGeneratedToday(): array {
        $generatedByHour = $this->backupService->getGeneratedTodayByHour();

        $byHour = collect(range(0, 23))
            ->map(fn (int $hour) => [
                'hour' => $hour,
                'quantity' => (int) ($generatedByHour[$hour] ?? 0),
            ])
            ->all();

        return [
            'byHour' => $byHour,
            'total' => $this->backupService->getTotalBackupsGeneratedToday(),
        ];
    }

    private function getClientsWithMostBackupRiskByPlan(): array
    {
        $plans = $this->planRepository->findAll();
        $res = [];
        foreach ($plans as $plan) {
            $res[] = $this->backupRiskService->getClientsWithMostRisks($plan->id, 5)->toArray();
        }
        return $res;
    }
}
