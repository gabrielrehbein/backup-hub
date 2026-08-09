<?php

namespace App\Modules\Backups\DTOs;

use App\Modules\Risks\Enums\RiskTypeEnum;


class FilterBackupRiskDTO
{

    public function __construct(
        public readonly ?int $backupId,
        public readonly ?int $riskId,
        public readonly ?RiskTypeEnum $type,
        public readonly ?bool $isActive,
        public readonly ?int $minDelayInMinutes,
        public readonly ?int $maxDelayInMinutes,
        public readonly ?int $minSizeLossPercent,
        public readonly ?int $maxSizeLossPercent,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            backupId: $data['backup_id'] ?? null,
            riskId: $data['risk_id'] ?? null,
            type: isset($data['type']) ? RiskTypeEnum::from($data['type']) : null,
            isActive: $data['is_active'] ?? null,
            minDelayInMinutes: $data['min_delay_in_minutes'] ?? null,
            maxDelayInMinutes: $data['max_delay_in_minutes'] ?? null,
            minSizeLossPercent: $data['min_size_loss_percent'] ?? null,
            maxSizeLossPercent: $data['max_size_loss_percent'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'backup_id' => $this->backupId,
            'risk_id' => $this->riskId,
            'type' => $this->type?->value,
            'is_active' => $this->isActive,
            'min_delay_in_minutes' => $this->minDelayInMinutes,
            'max_delay_in_minutes' => $this->maxDelayInMinutes,
            'min_size_loss_percent' => $this->minSizeLossPercent,
            'max_size_loss_percent' => $this->maxSizeLossPercent,
        ];
    }
}
