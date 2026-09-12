<?php

namespace App\Shared\Security\Actions;

use App\Shared\Security\Contracts\ApiKeyGeneratorInterface;
use App\Shared\Security\DTOs\UnhashedAndHashedApiKeyDTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UuidApiKeyGenerator implements ApiKeyGeneratorInterface
{
    public static function execute(): UnhashedAndHashedApiKeyDTO {
        $unhashedApiKey = (string) Str::uuid();
        $hashedApiKey = Hash::make($unhashedApiKey);

        return new UnhashedAndHashedApiKeyDTO(
            $unhashedApiKey,
            $hashedApiKey
        );
    }
}
