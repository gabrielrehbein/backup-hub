<?php

namespace App\Modules\Backups\DTOs;

use App\Shared\Utils\ArrayHelper;
use Carbon\CarbonImmutable;

class UpdateBackupDTO
{

    public function __construct(
        public readonly ?string $name,
        public readonly ?int $fileSize,
        public readonly ?CarbonImmutable $generatedAt,
        public readonly ?bool $isLocal,
        public readonly ?int $systemInstanceId,
        public readonly ?string $sourceIp,
        public readonly ?string $filePath,
        public readonly int $version,
    ){}

    public function toArray(): array
    {
        return ArrayHelper::removeNullValues([
            'name' => $this->name,
            'file_size' => $this->fileSize,
            'generated_at' => $this->generatedAt?->toDateTimeString(),
            'is_local' => $this->isLocal,
            'system_instance_id' => $this->systemInstanceId,
            'source_ip' => $this->sourceIp,
            'file_path' => $this->filePath,
            'version' => $this->version,
        ]);
    }

    public static function fromArray(array $data): UpdateBackupDTO
    {
        return new self(
            $data['name'] ?? null,
            $data['file_size'] ?? null,
            $data['generated_at'] ? CarbonImmutable::parse($data['generated_at']) : null,
            $data['is_local'] ?? null,
            $data['system_instance_id'] ?? null,
            $data['source_ip'] ?? null,
            $data['file_path'] ?? null,
            $data['version'] ?? null
        );
    }
}
