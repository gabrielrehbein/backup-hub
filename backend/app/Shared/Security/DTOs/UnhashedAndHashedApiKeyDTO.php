<?php

namespace App\Shared\Security\DTOs;


class UnhashedAndHashedApiKeyDTO
{
    public function __construct(
        readonly public string $unhashedApiKey,
        readonly public string $hashedApiKey,
    ){}

    public function toArray(): array {
        return [
            "unhashedApiKey" => $this->unhashedApiKey,
            "hashedApiKey" => $this->hashedApiKey,
        ];
    }
}
