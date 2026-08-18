<?php

namespace App\Modules\Auth\DTOs;

class LoginDTO
{

    public function __construct(
        public readonly string $email,
        public readonly string $password
    ){}

    public static function fromArray(array $array): self
    {
        return new self(
            email: $array['email'],
            password: $array['password']
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
