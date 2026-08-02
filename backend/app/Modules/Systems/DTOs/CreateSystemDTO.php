<?php

namespace App\Modules\Systems\DTOs;

use App\Modules\Systems\Enums\SystemCategoryEnum;

class CreateSystemDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description,
        public readonly SystemCategoryEnum $category,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            category: SystemCategoryEnum::from($data['category']),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category->value,
        ];
    }
}
