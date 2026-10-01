<?php

namespace App\Modules\Clients\Services;

use App\Modules\Clients\Contracts\Repositories\ClientRepositoryInterface;
use App\Modules\Clients\Contracts\Services\ClientServiceInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\FilterClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Models\Client;


use Illuminate\Support\Str;
use Override;

class ClientService implements ClientServiceInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository,

    ) {}

    public function create(CreateClientDTO $payload): Client {
        $client = $this->clientRepository->create($payload);
        return $client;
    }

    #[Override]
    public function list(FilterClientDTO $dto): iterable
    {
        return $this->clientRepository->list($dto);
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
        $client = $this->findById($id);
        return $this->clientRepository->update(
            $payload,
            $client
        );
    }

    public function findById(int $id): Client {
        return $this->clientRepository->findById($id);
    }

    public function findByExternalId(string $externalId): Client {
        return $this->clientRepository->findByExternalId($externalId);
    }

    public function getTotalClients(): int {
        return $this->clientRepository->getTotalClients();
    }
}
