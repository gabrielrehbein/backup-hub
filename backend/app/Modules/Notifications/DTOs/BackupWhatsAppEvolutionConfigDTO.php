<?php

namespace App\Modules\Notifications\DTOs;


class BackupWhatsAppEvolutionConfigDTO
{
    public function __construct(
        public readonly string $to,
        public readonly string $baseUrl,
        public readonly string $apiKey,
        public readonly string $instance,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            to: $data['to'],
            baseUrl: $data['base_url'],
            apiKey: $data['api_key'],
            instance: $data['instance'],
        );
    }

    public function toArray(): array
    {
        return [
            'to' => $this->to,
            'base_url' => $this->baseUrl,
            'api_key' => $this->apiKey,
            'instance' => $this->instance,
        ];
    }
}