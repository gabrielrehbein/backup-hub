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
}
