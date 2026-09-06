<?php

namespace App\Modules\Clients\Services;

use App\Modules\Clients\Contracts\Repositories\ClientRepositoryInterface;
use App\Modules\Clients\Contracts\Services\ClientAuthenticationServiceInterface;
use App\Modules\Clients\Errors\InvalidApiKeyHttpException;
use App\Modules\Clients\Models\Client;
use Illuminate\Support\Facades\Hash;
use App\Modules\Clients\Errors\ClientInactiveHttpException;

class ClientAuthenticationService implements ClientAuthenticationServiceInterface
{
    public function __construct(
        private ClientRepositoryInterface $clientRepository
    ) {}

    public function isValidAPIKey(string $apiKey): Client
    {
        $identifier = explode('.', $apiKey, 2)[0];
        $key = explode('.', $apiKey, 2)[1];

        $client = $this->clientRepository->findByApiKeyIdentifier($identifier);

        $clientIdentifier = explode('.', $client->api_key, 2)[0];
        $clientKey = explode('.', $client->api_key, 2)[1];

        if(!$client->is_active){
            throw new ClientInactiveHttpException();
        }
        if ($identifier !== $clientIdentifier || !Hash::check($key, $clientKey)) {
            throw new InvalidApiKeyHttpException();
        }

        return $client;
    }
}
