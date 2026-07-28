<?php

namespace App\Modules\Users\DTOs;

use App\Modules\Users\Enums\RoleUserEnum;
use App\Shared\Utils\ArrayHelper;

class UpdateUserDTO
{

    public function __construct(
        private readonly ?string $name,
        private readonly ?string $email,
        private readonly ?string $password,
        private readonly ?RoleUserEnum $role,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
            role: $data['role'] ?? null,
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
        ]);
    }


}
