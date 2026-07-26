<?php

namespace App\Modules\Risks\DTOs;

class CreateRiskDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $level,
        public readonly ?string $description,
        public readonly int $max_delay_limit_in_minutes,
        public readonly int $max_size_loss_in_percent,
        public readonly int $plan_id,
        public readonly bool $notifiable = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            level: $data['level'],
            description: $data['description'] ?? null,
            max_delay_limit_in_minutes: $data['max_delay_limit_in_minutes'],
            max_size_loss_in_percent: $data['max_size_loss_in_percent'],
            plan_id: $data['plan_id'],
            notifiable: $data['notifiable'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'level' => $this->level,
            'description' => $this->description,
            'max_delay_limit_in_minutes' => $this->max_delay_limit_in_minutes,
            'max_size_loss_in_percent' => $this->max_size_loss_in_percent,
            'plan_id' => $this->plan_id,
            'notifiable' => $this->notifiable,
        ];
    }
}
