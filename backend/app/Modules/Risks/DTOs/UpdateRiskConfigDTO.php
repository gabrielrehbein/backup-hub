<?php

namespace App\Modules\Risks\DTOs;

use App\Shared\Utils\ArrayHelper;


class UpdateRiskConfigDTO
{
    public function __construct(
        public readonly ?int $max_delay_limit_in_minutes,
        public readonly ?int $max_size_loss_in_percent,
        public readonly ?string $description,
        public readonly ?bool $notifiable = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
        max_delay_limit_in_minutes: $data['max_delay_limit_in_minutes'] ?? null,
        max_size_loss_in_percent: $data['max_size_loss_in_percent'] ?? null,
        notifiable: $data['notifiable'] ?? null,
        description: $data['description'] ?? null,
        );
    }

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'max_delay_limit_in_minutes' => $this->max_delay_limit_in_minutes,
            'max_size_loss_in_percent' => $this->max_size_loss_in_percent,
            'notifiable' => $this->notifiable,
            'description' => $this->description
        ]);
    }
}
