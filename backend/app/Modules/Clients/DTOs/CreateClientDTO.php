<?php

namespace App\Modules\Clients\DTOs;

class CreateClientDTO
{
    public string $api_key;

    public function __construct(
        public readonly string $name,
        public readonly string $external_id,
        public readonly int $plan_id,

        public readonly bool $is_active = true,
        public readonly ?string $description = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            external_id: $data['external_id'],
            plan_id: $data['plan_id'],
            is_active: $data['is_active'] ?? true,
            description: $data['description'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'external_id' => $this->external_id,
            'plan_id' => $this->plan_id,
            'is_active' => $this->is_active,
            'description' => $this->description,
        ];
    }
}
