<?php

namespace App\Modules\Backups\DTOs;

use App\Modules\Backups\Enums\SizeTypeEnum;
use Carbon\CarbonImmutable;

class CreateBackupRequestDTO
{

    public function __construct(
        public readonly int $fileSize,
        public readonly CarbonImmutable $generatedAt,
        public readonly bool $isLocal,
        public readonly int $systemInstanceId,
        public readonly string $sourceIp,
        public readonly string $filePath,
        public readonly string $version,
        public readonly ?SizeTypeEnum $sizeType = SizeTypeEnum::KB,
    ){}

    public function toArray(): array
    {
        return [
            'file_size' => $this->fileSize,
            'generated_at' => $this->generatedAt->toDateTimeString(),
            'is_local' => $this->isLocal,
            'system_instance_id' => $this->systemInstanceId,
            'source_ip' => $this->sourceIp,
            'file_path' => $this->filePath,
            'version' => $this->version,
        ];
    }

    public static function fromArray(array $data): CreateBackupRequestDTO
    {
        return new self(
            $data['file_size'],
            CarbonImmutable::parse($data['generated_at']),
            $data['is_local'],
            $data['system_instance_id'],
            $data['source_ip'],
            $data['file_path'],
            $data['version'],
        );
    }
}

