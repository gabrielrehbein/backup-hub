<?php

namespace App\Shared\DTOs;

class BodyResponse
{

    public function __construct(
        public readonly mixed $data,
        public readonly string $message = '',
    )
    {
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'message' => $this->message,
        ];
    }
}
