<?php

namespace App\Modules\Users\DTOs;

use App\Modules\Users\Enums\RoleUserEnum;

class CreateUserDTO
{

    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $phone,
        private readonly string $password,
        private readonly RoleUserEnum $role,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            password: $data['password'],
            role: RoleUserEnum::from($data['role'] ?? RoleUserEnum::DEFAULT->value),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
            'role' => $this->role?->value,
        ];
    }


}
