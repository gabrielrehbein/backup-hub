<?php

namespace App\Modules\Clients\Contracts\Services;

use App\Modules\Clients\Contracts\Repositories\ClientRepositoryInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\ResponseCreateClientWithUnhashedApiKeyDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Models\Client;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

class ClientService implements ClientServiceInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository
    ) {}

    public function create(CreateClientDTO $payload): ResponseCreateClientWithUnhashedApiKeyDTO {
        $UuidApiKey = (string) Str::uuid();

        $hashedApiKey = Hash::make($UuidApiKey);

        $payload->api_key = $hashedApiKey;

        $client = $this->clientRepository->create($payload);

        $responseCreateClientWithUnhashedApiKeyDTO = new ResponseCreateClientWithUnhashedApiKeyDTO(
            $client,
            $UuidApiKey
        );

        return $responseCreateClientWithUnhashedApiKeyDTO;
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
