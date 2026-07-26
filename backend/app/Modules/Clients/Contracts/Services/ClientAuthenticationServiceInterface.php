<?php

namespace App\Modules\Clients\Contracts\Services;

use App\Modules\Clients\Models\Client;

interface ClientAuthenticationServiceInterface
{
    public function authenticate(int $clientId, string $apiKey): Client;
}
