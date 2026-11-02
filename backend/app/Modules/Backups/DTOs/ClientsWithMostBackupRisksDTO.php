<?php

namespace App\Modules\Backups\DTOs;

class ClientsWithMostBackupRisksDTO
{
    public function __construct(
        public readonly string $planName,
        public readonly array $summary,
    ) {}

    public function toArray(): array
    {
        return [
            'plan_name' => $this->planName,
            'summary' => $this->summary,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['plan_name'],
            $data['summary']
        );
    }
}
