<?php

namespace App\Modules\Clients\Contracts\Services;

use App\Modules\Clients\Models\Client;

interface ClientAuthenticationServiceInterface
{
    public function isValidAPIKey(string $externalClientId, string $apiKey): bool;
}
