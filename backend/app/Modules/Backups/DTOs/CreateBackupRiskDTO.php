<?php

namespace App\Modules\Backups\DTOs;

use App\Modules\Risks\Enums\RiskTypeEnum;

class CreateBackupRiskDTO
{

    public function __construct(
        public readonly int $backupId,
        public readonly int $riskId,
        public readonly RiskTypeEnum $type,
        public readonly bool $isActive,
        public readonly int $delayInMinutes,
        public readonly int $sizeLossPercent,
        public readonly string $description,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            backupId: $data['backup_id'],
            riskId: $data['risk_id'],
            type: RiskTypeEnum::from($data['type']),
            isActive: $data['is_active'],
            delayInMinutes: $data['delay_in_minutes'],
            sizeLossPercent: $data['size_loss_percent'],
            description: $data['description']
        );
    }

    public function toArray(): array
    {
        return [
            'backup_id' => $this->backupId,
            'risk_id' => $this->riskId,
            'type' => $this->type->value,
            'is_active' => $this->isActive,
            'delay_in_minutes' => $this->delayInMinutes,
            'size_loss_percent' => $this->sizeLossPercent,
            'description' => $this->description
        ];
    }
}
