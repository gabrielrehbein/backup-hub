<?php

namespace App\Modules\Clients\DTOs;

use App\Shared\Utils\ArrayHelper;

class UpdatePlanDTO
{

    public function __construct(
        readonly public ?string $name,
        readonly public ?string $description = null
    )
    {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }
}
