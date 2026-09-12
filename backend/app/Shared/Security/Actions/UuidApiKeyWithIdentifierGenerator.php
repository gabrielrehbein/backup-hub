<?php

namespace App\Shared\Security\Actions;

use App\Shared\Security\Contracts\ApiKeyGeneratorInterface;
use App\Shared\Security\DTOs\UnhashedAndHashedApiKeyDTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UuidApiKeyWithIdentifierGenerator implements ApiKeyGeneratorInterface
{
    public static function execute(): UnhashedAndHashedApiKeyDTO {
        $identifier = (string) Str::uuid();

        $unhashedApiKey = (string) Str::uuid();
        $hashedApiKey = Hash::make($unhashedApiKey);

        $unhashedApiKeyWithIdentifier = $identifier . "." . $unhashedApiKey;
        $hashedApiKeyWithIdentifier = $identifier . "." . $hashedApiKey;

        return new UnhashedAndHashedApiKeyDTO(
            $unhashedApiKeyWithIdentifier,
            $hashedApiKeyWithIdentifier
        );
    }
}
