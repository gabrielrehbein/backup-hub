<?php

namespace App\Modules\Clients\Services;


use App\Modules\Clients\Errors\InvalidApiKeyHttpException;
use App\Modules\Clients\Models\Client;
use Illuminate\Support\Facades\Hash;
use App\Modules\Clients\Errors\ClientInactiveHttpException;
use App\Modules\Systems\Contracts\Repositories\SystemInstanceRepositoryInterface;
use App\Modules\Systems\Contracts\Services\SystemInstanceAuthenticationServiceInterface;
use App\Modules\Systems\Models\SystemInstance;


class SystemInstanceAuthenticationService implements SystemInstanceAuthenticationServiceInterface
{
    public function __construct(
        private SystemInstanceRepositoryInterface $instanceRepository
    ) {}

    public function isValidAPIKey(string $apiKey): SystemInstance
    {
        $identifier = explode('.', $apiKey, 2)[0];
        $key = explode('.', $apiKey, 2)[1];

        $instance = $this->instanceRepository->findByApiKeyIdentifier($identifier);
        $client = $instance->client;

        $instanceIdentifier = explode('.', $instance->api_key, 2)[0];
        $instanceKey = explode('.', $instance->api_key, 2)[1];

        if(!$client->is_active){
            throw new ClientInactiveHttpException();
        }
        if ($identifier !== $instanceIdentifier || !Hash::check($key, $instanceKey)) {
            throw new InvalidApiKeyHttpException();
        }

        return $instance;
    }
}
