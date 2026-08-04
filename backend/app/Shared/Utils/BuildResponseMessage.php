<?php

namespace App\Shared\Utils;

class BuildResponseMessage
{
    public static function findAll(ResourceEnum $resource): string
    {
        return "{$resource->value} listado com sucesso.";
    }

    public static function findOne(ResourceEnum $resource): string
    {
        return "{$resource->value} encontrado com sucesso.";
    }

    public static function create(ResourceEnum $resource): string
    {
        return "{$resource->value} criado com sucesso.";
    }

    public static function update(ResourceEnum $resource): string
    {
        return "{$resource->value} atualizado com sucesso.";
    }

    public static function delete(ResourceEnum $resource): string
    {
        return "{$resource->value} deletado com sucesso.";
    }
}
