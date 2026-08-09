<?php

namespace App\Modules\Backups\DTOs;

use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Shared\Utils\ArrayHelper;

class UpdateBackupRiskDTO
{

    public function __construct(
        public readonly ?int $backupId,
        public readonly ?int $riskId,
        public readonly ?RiskTypeEnum $type,
        public readonly ?bool $isActive,
        public readonly ?int $delayInMinutes,
        public readonly ?int $sizeLossPercent,
        public readonly ?string $description,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            backupId: $data['backup_id'] ?? null,
            riskId: $data['risk_id'] ?? null,
            type: isset($data['type']) ? RiskTypeEnum::from($data['type']) : null,
            isActive: $data['is_active'] ?? null,
            delayInMinutes: $data['delay_in_minutes'] ?? null,
            sizeLossPercent: $data['size_loss_percent'] ?? null,
            description: $data['description'] ?? null
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'backup_id' => $this->backupId,
            'risk_id' => $this->riskId,
            'type' => $this->type?->value,
            'is_active' => $this->isActive,
            'delay_in_minutes' => $this->delayInMinutes,
            'size_loss_percent' => $this->sizeLossPercent,
            'description' => $this->description
        ]);
    }
}
