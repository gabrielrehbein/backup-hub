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

    public function authenticate(int $externalId, string $apiKey): Client
    {
        $client = $this->clientRepository->findById($externalId);

        if(!$client->is_active){
            throw new ClientInactiveHttpException();
        }
        if (!Hash::check($apiKey, $client->api_key)) {
            throw new InvalidApiKeyHttpException();
        }

        return $client;
    }
}
