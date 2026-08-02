<?php

namespace App\Modules\Users\DTOs;

use App\Modules\Users\Enums\RoleUserEnum;
use App\Shared\Utils\ArrayHelper;

class UpdateUserDTO
{

    public function __construct(
        private readonly ?string $name,
        private readonly ?RoleUserEnum $role,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            role: $data['role'] ?? null,
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'name' => $this->name,
            'role' => $this->role,
        ]);
    }
}
