<?php

namespace App\Modules\Notifications\DTOs;


class BackupMailConfigDTO
{
    public function __construct(
        public readonly string $to,
    ){}

    public static function fromArray(array $data): self {
        return new self(
            to: $data['to'],
        );
    }

    public function toArray(): array {
        return [
            'to' => $this->to,
        ];
    }
}
