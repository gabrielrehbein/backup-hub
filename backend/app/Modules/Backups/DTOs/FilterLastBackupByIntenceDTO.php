<?php

namespace App\Modules\Backups\DTOs;

use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Shared\Utils\ArrayHelper;
use Carbon\CarbonImmutable;

class FilterLastBackupByIntenceDTO
{
    public function __construct(
        public readonly ?int $planId = null,
        public readonly ?int $clientId = null,
        public readonly ?string $riskName = null,
        public readonly ?RiskTypeEnum $riskType = null,
        public readonly ?CarbonImmutable $generatedAtStart = null,
        public readonly ?CarbonImmutable $generatedAtEnd = null,
        public readonly ?int $minSize = null,
        public readonly ?int $maxSize = null,
        public readonly ?string $version = null,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            planId: isset($data['plan_id']) ? (int) $data['plan_id'] : null,
            clientId: isset($data['client_id']) ? (int) $data['client_id'] : null,
            riskName: $data['risk_name'] ?? null,
            riskType: isset($data['risk_type']) ? RiskTypeEnum::from($data['risk_type']) : null,
            generatedAtStart: isset($data['generated_at_start']) ? CarbonImmutable::parse($data['generated_at_start']) : null,
            generatedAtEnd: isset($data['generated_at_end']) ? CarbonImmutable::parse($data['generated_at_end']) : null,
            minSize: isset($data['min_size']) ? (int) $data['min_size'] : null,
            maxSize: isset($data['max_size']) ? (int) $data['max_size'] : null,
            version: $data['version'] ?? null
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'plan_id' => $this->planId,
            'client_id' => $this->clientId,
            'risk_name' => $this->riskName,
            'risk_type' => $this->riskType?->value,
            'generated_at_start' => $this->generatedAtStart?->toIso8601String(),
            'generated_at_end' => $this->generatedAtEnd?->toIso8601String(),
            'min_size' => $this->minSize,
            'max_size' => $this->maxSize,
            'version' => $this->version,
        ]);
    }
}
