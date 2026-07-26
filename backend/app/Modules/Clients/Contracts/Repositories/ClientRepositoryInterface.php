<?php

namespace App\Modules\Clients\Contracts\Repositories;

use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Models\Client;


interface ClientRepositoryInterface
{
    public function create(CreateClientDTO $payload): Client;
    public function findAll(): iterable;
    public function delete(Client $client): bool;
    public function update(UpdateClientDTO $payload, Client $client): Client;
    public function findById(int $id): Client;
    public function findByExternalId(string $externalId): Client;
}
