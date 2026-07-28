<?php

namespace App\Modules\Clients\Services;

use App\Modules\Clients\Contracts\Repositories\ClientRepositoryInterface;
use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\ResponseCreateClientWithUnhashedApiKeyDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Models\Client;
use App\Shared\Security\Contracts\ApiKeyGeneratorInterface;
use App\Shared\Utils\ApiKeyHelper;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Override;

class ClientService implements ClientServiceInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly ApiKeyGeneratorInterface $apiKeyGenerator,
    ) {}

    public function create(CreateClientDTO $payload): Client {
        $apiKeyDTO = $this->apiKeyGenerator->execute();

        $payload->api_key = $apiKeyDTO->hashedApiKey;

        $client = $this->clientRepository->create($payload);

        $client->api_key = $apiKeyDTO->unhashedApiKey;

        return $client;
    }

    public function refreshApiKey(int $id): string
    {
        $client = $this->findById($id);
        $apiKeyDTO = $this->apiKeyGenerator->execute();
        $client = $this->clientRepository->update(UpdateClientDTO::fromArray(["api_key" => $apiKeyDTO->hashedApiKey]), $client);
        return $apiKeyDTO->unhashedApiKey;
    }

    public function findAll(): iterable {
        return $this->clientRepository->findAll();
    }
    public function delete(int $id): bool {
        return $this->clientRepository->delete(
            $this->clientRepository->findById($id)
        );
    }
    public function update(UpdateClientDTO $payload, int $id): Client {
        return $this->clientRepository->update(
            $payload,
            $this->clientRepository->findById($id)
        );
    }

    public function findById(int $id): Client {
        return $this->clientRepository->findById($id);
    }

    public function findByExternalId(string $externalId): Client {
        return $this->clientRepository->findByExternalId($externalId);
    }
}
