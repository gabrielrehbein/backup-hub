<?php

namespace App\Modules\Clients\Contracts\Services;

use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\FilterClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Models\Client;


interface ClientServiceInterface
{
    public function create(CreateClientDTO $payload): Client;
    public function findAll(): iterable;
    public function list(FilterClientDTO $dto): iterable;
    public function delete(int $id): bool;
    public function update(UpdateClientDTO $payload, int $id): Client;
    public function findById(int $id): Client;
    public function findByExternalId(string $externalId): Client;
    public function getTotalClients(): int;
}
