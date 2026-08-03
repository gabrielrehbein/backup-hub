<?php

namespace App\Modules\Systems\DTOs;

use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Shared\Utils\ArrayHelper;

class UpdateSystemInstanceDTO
{
    public function __construct(
        public readonly ?string $version,
        public readonly ?int $clientId,
        public readonly ?int $systemId,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            version: $data['version'] ?? null,
            clientId: $data['client_id'] ?? null,
            systemId: $data['system_id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'version' => $this->version,
            'client_id' => $this->clientId,
            'system_id' => $this->systemId,
        ]);
    }
}
