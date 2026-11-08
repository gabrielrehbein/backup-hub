<?php

namespace App\Modules\Systems\Contracts\Services;

use App\Modules\Clients\Models\Client;
use App\Modules\Systems\Models\SystemInstance;

interface SystemInstanceAuthenticationServiceInterface
{
    public function isValidAPIKey(string $apiKey): ?SystemInstance;
}
