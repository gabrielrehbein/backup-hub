<?php

namespace App\Modules\Systems\Services;


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
        $parts = explode('.', $apiKey, 2);

        if (count($parts) !== 2) {
            throw new InvalidApiKeyHttpException();
        }

        [$identifier, $key] = $parts;

        $instance = $this->instanceRepository->findByApiKeyIdentifier($identifier);

        if (!$instance) {
            throw new InvalidApiKeyHttpException();
        }

        [$instanceIdentifier, $instanceKey] = array_pad(explode('.', $instance->api_key, 2), 2, null);

        if ($identifier !== $instanceIdentifier || !$instanceKey || !Hash::check($key, $instanceKey)) {
            throw new InvalidApiKeyHttpException();
        }

        if (!$instance->client->is_active) {
            throw new ClientInactiveHttpException();
        }

        return $instance;
    }
}
