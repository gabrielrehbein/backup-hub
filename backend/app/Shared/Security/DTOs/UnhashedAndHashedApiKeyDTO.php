<?php

namespace App\Shared\Security\DTOs;

class UnhashedAndHashedApiKeyDTO
{
    public function __construct(
        public readonly string $unhashedApiKey,
        public readonly string $hashedApiKey
    ) {}

    public function toArray(): array
    {
        return [
            'unhashedApiKey' => $this->unhashedApiKey,
            'hashedApiKey' => $this->hashedApiKey,
        ];
    }
}
