<?php

namespace App\Modules\Backups\DTOs;

use App\Modules\Backups\Enums\SizeTypeEnum;
use App\Modules\Risks\Enums\RiskTypeEnum;
use App\Shared\Utils\ArrayHelper;
use Carbon\CarbonImmutable;


class BackupFilterDTO
{
    public function __construct(
        public readonly ?CarbonImmutable $startGeneratedAt,
        public readonly ?CarbonImmutable $endGeneratedAt,
        public readonly ?int $minSize,
        public readonly ?int $maxSize,
        public readonly ?bool $isLocal,
        public readonly ?int $systemInstanceId,
        public readonly ?int $riskId,
        public readonly ?int $clientId,
        public readonly ?RiskTypeEnum $riskType,
        public readonly ?int $perPage,
        public readonly ?SizeTypeEnum $returnInSizeType,
    ){}

    public function toArray(){
        return ArrayHelper::removeNullValues([
            'start_generatedAt' => $this->startGeneratedAt,
            'end_generatedAt' => $this->endGeneratedAt,
            'min_size' => $this->minSize,
            'max_size' => $this->maxSize,
            'is_local' => $this->isLocal,
            'system_instance_id' => $this->systemInstanceId,
            'risk_id' => $this->riskId,
            'client_id' => $this->clientId,
            'risk_type' => $this->riskType?->value,
            'per_page' => $this->perPage,
            'return_in_size_type' => $this->returnInSizeType,
        ]);
    }

    public function fromArray(array $data): BackupFilterDTO
    {
        return new self(
            $data['start_generatedAt'] ? CarbonImmutable::parse($data['start_generatedAt']) : null,
            $data['end_generatedAt'] ? CarbonImmutable::parse($data['end_generatedAt']) : null,
            $data['min_size'] ?? null,
            $data['max_size'] ?? null,
            $data['is_local'] ?? null,
            $data['system_instance_id'] ?? null,
            $data['risk_id'] ?? null,
            $data['client_id'] ?? null,
            isset($data['risk_type']) ? RiskTypeEnum::from($data['risk_type']) : null,
            $data['per_page'] ?? null,
            $data['return_in_size_type'] ?? null,
        );
    }
}
