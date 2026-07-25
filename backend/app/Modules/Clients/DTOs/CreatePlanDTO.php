<?php

namespace App\Modules\Clients\DTOs;

class CreatePlanDTO
{

    public function __construct(
        readonly public string $name,
        readonly public ?string $description = null
    )
    {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
