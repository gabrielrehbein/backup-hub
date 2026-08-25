<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Modules\Backups\Contracts\Services\BackupRiskServiceInterface;
use App\Modules\Backups\Contracts\Services\BackupServiceInterface;
use App\Shared\Http\Responses\JSONResponse;
use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use Illuminate\Http\Request;
use App\Modules\Backups\Http\Resources\LastBackupsResource;


class DashboardController
{
    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly BackupServiceInterface $backupService,
        private readonly BackupRiskServiceInterface $backupRiskService,
    ){}

    public function getMetrics(Request $request)
    {
        $data = [
            'summary' => [
                'total_clients' => $this->clientService->getTotalClients(),
                'total_backups' => $this->backupService->getTotalBackups(),
                'risk_backups' => $this->backupRiskService->getTotalBackupRisks(),
            ],

            'riskDistribution' => [
                [
                    'name' => 'Low',
                    'level' => 1,
                    'quantity' => 20,
                ],
                [
                    'name' => 'Medium',
                    'level' => 2,
                    'quantity' => 15,
                ],
                [
                    'name' => 'High',
                    'level' => 3,
                    'quantity' => 10,
                ],
            ],

            'riskByType' => $this->backupRiskService->getTotalBackupRisksByType(),

            'recentBackups' => [
                'local' => LastBackupsResource::collection($this->backupService->findLastBackups(10, true)),
                'remote' => LastBackupsResource::collection($this->backupService->findLastBackups(10, false)),
            ],

            'backupsGeneratedToday' => [
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
            ],

            'clientsWithMostBackupRiskByPlan' => [
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
            ],
        ];

        return JSONResponse::success($data, "Dashboard recuperado com sucesso!");
    }
}
