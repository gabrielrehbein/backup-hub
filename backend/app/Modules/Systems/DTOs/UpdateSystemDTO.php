<?php

namespace App\Modules\Systems\DTOs;

use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Shared\Utils\ArrayHelper;

class UpdateSystemDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $description,
        public readonly ?SystemCategoryEnum $category,
    ){}

    public static function fromArray(array $data): self
    {
        $category = isset($data['category']) ? SystemCategoryEnum::from($data['category']) : null;

        return new self(
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            category: $category,
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category?->value,
        ]);
    }
}
