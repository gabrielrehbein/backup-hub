<?php

namespace App\Modules\Systems\DTOs;

use App\Modules\Systems\Enums\SystemCategoryEnum;

class CreateSystemDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly int $category_id,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            category_id: $data["category_id"],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];
    }
}
