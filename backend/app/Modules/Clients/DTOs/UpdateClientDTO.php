<?php

namespace App\Modules\Clients\DTOs;

use App\Shared\Utils\ArrayHelper;

class UpdateClientDTO
{
    public function __construct(
        readonly public ?string $name,
        readonly public ?string $external_id,
        readonly public ?int $plan_id,
        readonly public ?string $api_key,
        readonly public ?bool $is_active,
        readonly public ?string $description,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            external_id: $data['external_id'] ?? null,
            plan_id: $data['plan_id'] ?? null,
            api_key: $data['api_key'] ?? null,
            is_active: $data['is_active'] ?? null,
            description: $data['description'] ?? null,
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'name' => $this->name,
            'external_id' => $this->external_id,
            'plan_id' => $this->plan_id,
            'api_key' => $this->api_key,
            'is_active' => $this->is_active,
            'description' => $this->description,
        ]);
    }
}
