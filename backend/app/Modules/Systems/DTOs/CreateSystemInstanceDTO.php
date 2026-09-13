<?php

namespace App\Modules\Systems\DTOs;

use App\Modules\Systems\Enums\SystemCategoryEnum;


class CreateSystemInstanceDTO
{
    public string $apiKey;

    public function __construct(
        public readonly string $version,
        public readonly int $clientId,
        public readonly int $systemId,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            version: $data['version'],
            clientId: $data['client_id'],
            systemId: $data['system_id'],
        );
    }

    public function toArray(): array
    {
        return [
            'version' => $this->version,
            'client_id' => $this->clientId,
            'system_id' => $this->systemId,
            'api_key' => $this->apiKey,
        ];
    }
}
