<?php

namespace App\Modules\Clients\DTOs;


class CreateClientDTO
{
    public string $api_key;

    public function __construct(
        readonly public string $name,
        readonly public string $external_id,
        readonly public int $plan_id,

        readonly public bool $is_active = true,
        readonly public ?string $description = null,
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
            'api_key' => $this->api_key,
            'is_active' => $this->is_active,
            'description' => $this->description,
        ];
    }
}
