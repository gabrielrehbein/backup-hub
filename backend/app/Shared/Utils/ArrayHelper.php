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

    public static function arrayToFormRequestValidation(array $array): string
    {
        return implode(',', array_map(fn($value) => $value->value, $array));
    }
}
