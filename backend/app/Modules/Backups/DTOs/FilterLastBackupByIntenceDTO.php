<?php

namespace App\Modules\Backups\DTOs;

use App\Modules\Risks\Enums\RiskTypeEnum;


class FilterLastBackupByIntenceDTO
{
    public function __construct(
        public readonly ?string $plan_id,
        public readonly ?string $client_id,
        public readonly ?string $riskName,
        public readonly ?RiskTypeEnum $riskType,
        public readonly ?int $generatedAtStart,
        public readonly ?int $generatedAtEnd,
        public readonly ?int $minSize,
        public readonly ?int $maxSize,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            plan_id: $data['plan_id'] ?? null,
            client_id: $data['client_id'] ?? null,
            riskName: $data['risk_id'] ?? null,
            riskType: isset($data['type']) ? RiskTypeEnum::from($data['type']) : null,
            generatedAtStart: $data['generated_at_start'] ?? null,
            generatedAtEnd: $data['generated_at_end'] ?? null,
            minSize: $data['min_size'] ?? null,
            maxSize: $data['max_size'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'plan_id' => $this->plan_id,
            'client_id' => $this->client_id,
            'risk_name' => $this->riskName,
            'risk_type' => $this->riskType?->value,
            'generated_at_start' => $this->generatedAtStart,
            'generated_at_end' => $this->generatedAtEnd,
            'min_size' => $this->minSize,
            'max_size' => $this->maxSize,
        ];
    }
}
