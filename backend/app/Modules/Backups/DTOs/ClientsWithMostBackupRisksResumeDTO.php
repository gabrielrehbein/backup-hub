<?php

namespace App\Modules\Backups\DTOs;

class ClientsWithMostBackupRisksResumeDTO
{
    public function __construct(
        public readonly int $planId,
        public readonly int $riskQuantity,
        public readonly string $clientName,
        public readonly int $clientId,
    ) {}

    public function toArray(): array
    {
        return [
            'plan_id' => $this->planId,
            'risk_quantity' => $this->riskQuantity,
            'client_name' => $this->clientName,
            'client_id' => $this->clientId,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['plan_id'],
            (int) $data['risk_quantity'],
            $data['client_name'],
            (int) $data['client_id'],
        );
    }
}
