<?php

namespace App\Modules\Backups\DTOs;

use App\Modules\Risks\Enums\RiskTypeEnum;

class ErrorTypeQuantityDTO
{
    public function __construct(
        public readonly RiskTypeEnum $type,
        public readonly int $quantity,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            type: RiskTypeEnum::from($data['type']),
            quantity: $data['quantity'],
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'quantity' => $this->quantity,
        ];
    }
}