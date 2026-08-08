<?php

namespace App\Modules\Backups\Actions;

use App\Modules\Backups\Enums\SizeTypeEnum;

class SizeConveterAction
{
    public static function toKb(float $value, SizeTypeEnum $sizeType): int
    {
        return match ($sizeType) {
            SizeTypeEnum::KB => (int) $value,
            SizeTypeEnum::MB => (int) ($value * 1024),
            SizeTypeEnum::GB => (int) ($value * 1024 * 1024),
        };
    }

    public static function fromKb(float $value, SizeTypeEnum $sizeType): int
    {
        return match ($sizeType) {
            SizeTypeEnum::KB => (float) $value,
            SizeTypeEnum::MB => (float) ($value / 1024),
            SizeTypeEnum::GB => (float) ($value / 1024 / 1024),
        };
    }

    public static function toMB(float $value, SizeTypeEnum $sizeType): int
    {
        return match ($sizeType) {
            SizeTypeEnum::KB => (float) ($value / 1024),
            SizeTypeEnum::MB => (float) $value,
            SizeTypeEnum::GB => (float) ($value * 1024),
        };
    }

    public static function toGB(float $value, SizeTypeEnum $sizeType): int
    {
        return match ($sizeType) {
            SizeTypeEnum::KB => (float) ($value / 1024 / 1024),
            SizeTypeEnum::MB => (float) ($value / 1024),
            SizeTypeEnum::GB => (float) $value,
        };
    }
}
