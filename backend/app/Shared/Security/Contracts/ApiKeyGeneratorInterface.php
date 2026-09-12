<?php

namespace App\Shared\Security\Contracts;

use App\Shared\Security\DTOs\UnhashedAndHashedApiKeyDTO;

interface ApiKeyGeneratorInterface
{
    public static function execute(): UnhashedAndHashedApiKeyDTO;
}
