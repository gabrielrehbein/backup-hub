<?php

namespace App\Modules\Users\DTOs;

use App\Modules\Users\Enums\RoleUserEnum;

class CreateUserDTO
{

    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
        private readonly RoleUserEnum $role,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            role: $data['role'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
        ];
    }


}
