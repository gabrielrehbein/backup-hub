<?php

namespace App\Modules\Systems\DTOs;

use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Shared\Utils\ArrayHelper;

class UpdateSystemDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $description,
        public readonly ?int $category_id,
    ){}

    public static function fromArray(array $data): self
    {

        return new self(
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            category_id: $data["category"] ?? null,
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ]);
    }
}
