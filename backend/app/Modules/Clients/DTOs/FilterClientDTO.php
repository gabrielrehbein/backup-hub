<?php

namespace App\Modules\Clients\DTOs;


readonly class FilterClientDTO {
    public function __construct(
        public ?string $name = null,
        public ?string $planId = null,
        public ?bool $isActive = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            planId: $data['plan_id'] ?? null,
            isActive: $data['is_active'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'plan_id' => $this->planId,
            'is_active' => $this->isActive,
        ];
    }


}
