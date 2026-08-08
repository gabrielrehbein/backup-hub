<?php

namespace App\Modules\Clients\Repositories;

use App\Modules\Clients\Contracts\Repositories\ClientRepositoryInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Models\Client;


class ClientEloquentRepository implements ClientRepositoryInterface
{
    public function create(CreateClientDTO $payload): Client {
        return Client::create($payload->toArray());
    }
    public function findAll(): iterable {
        return Client::all();
    }
    public function delete(Client $client): bool {
        return $client->delete();
    }
    public function update(UpdateClientDTO $payload, Client $client): Client {
        $client->fill(
            $payload->toArray()
        );
        if($client->isDirty()){
            $client->save();
        }
        return $client;
    }
    public function refreshApiKey(string $apiKey, Client $client): Client
    {
        $client->api_key = $apiKey;
        $client->save();
        return $client;
    }
    public function findById(int $id): Client {
        return Client::findOrFail($id);
    }
    public function findByExternalId(string $externalId): Client {
        return Client::firstWhere("external_id", $externalId);
    }
}
