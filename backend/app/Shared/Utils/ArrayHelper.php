<?php
namespace App\Shared\Utils;

class ArrayHelper
{
    public static function removeNullValues(array $values): array
    {
        return array_filter(
            $values,
            static fn ($value) => $value !== null
        );
    }
}
