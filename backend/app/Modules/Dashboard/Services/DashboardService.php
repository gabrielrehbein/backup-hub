<?php

namespace App\Modules\Dashboard\Services;


use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Backups\Http\Resources\LastBackupsResource;
use App\Modules\Dashboard\Contracts\Services\DashboardServiceInterface;
use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Dashboard\DTOs\MetricsDTO;

class DashboardService implements DashboardServiceInterface {

    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly BackupServiceInterface $backupService,
        private readonly BackupRiskServiceInterface $backupRiskService,
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
            'risk_backups' => $this->backupRiskService->getTotalBackupRisks(),
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
        return [
            'byHour' => [
                ['hour' => 0, 'quantity' => 0],
                ['hour' => 1, 'quantity' => 4],
                ['hour' => 2, 'quantity' => 2],
                ['hour' => 3, 'quantity' => 2],
                ['hour' => 4, 'quantity' => 4],
                ['hour' => 5, 'quantity' => 3],
                ['hour' => 6, 'quantity' => 2],
                ['hour' => 7, 'quantity' => 5],
                ['hour' => 8, 'quantity' => 1],
                ['hour' => 9, 'quantity' => 2],
                ['hour' => 10, 'quantity' => 1],
                ['hour' => 11, 'quantity' => 1],
                ['hour' => 12, 'quantity' => 3],
                ['hour' => 13, 'quantity' => 0],
                ['hour' => 14, 'quantity' => 4],
                ['hour' => 15, 'quantity' => 0],
                ['hour' => 16, 'quantity' => 8],
                ['hour' => 17, 'quantity' => 6],
                ['hour' => 18, 'quantity' => 3],
                ['hour' => 19, 'quantity' => 3],
                ['hour' => 20, 'quantity' => 0],
                ['hour' => 21, 'quantity' => 2],
                ['hour' => 22, 'quantity' => 1],
                ['hour' => 23, 'quantity' => 0],
            ],
            'total' => $this->backupService->getTotalBackupsGeneratedToday(),
        ];
    }

    private function getClientsWithMostBackupRiskByPlan(): array
    {
        return [
                [
                    'planName' => 'Platina',
                    'clients' => [
                        [
                            'clientName' => 'Mercado Krolow',
                            'riskQuantity' => 12,
                        ],
                        [
                            'clientName' => 'Empel',
                            'riskQuantity' => 9,
                        ],
                    ],
                ],

                [
                    'planName' => 'Bronze',
                    'clients' => [
                        [
                            'clientName' => 'Love Mackup',
                            'riskQuantity' => 2,
                        ],
                        [
                            'clientName' => 'Transportes Munchow',
                            'riskQuantity' => 1,
                        ],
                    ],
                ],
            ];
    }
}
