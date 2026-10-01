<?php

namespace App\Modules\Clients\Repositories;

use App\Modules\Clients\Contracts\Repositories\ClientRepositoryInterface;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\DTOs\FilterClientDTO;
use App\Modules\Clients\DTOs\UpdateClientDTO;
use App\Modules\Clients\Models\Client;


class ClientEloquentRepository implements ClientRepositoryInterface
{
    public function create(CreateClientDTO $payload): Client {
        return Client::create($payload->toArray());
    }

    public function list(FilterClientDTO $dto): iterable {
        return Client::query()
            ->when(
                $dto->name != null,
                function ($query) use($dto){
                    $query->where("name", "LIKE", "%{$dto->name}%");
                }
            )
            ->when(
                $dto->isActive != null,
                function($query) use($dto){
                    $query->where("is_active", $dto->isActive);
                }
            )
            ->when(
                $dto->planId != null,
                function($query) use($dto){
                    $query->where("plan_id", "=", $dto->planId);
                }
            )
            ->get();
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
    public function findById(int $id): Client {
        return Client::findOrFail($id);
    }
    public function findByExternalId(string $externalId): Client {
        return Client::firstWhere("external_id", $externalId);
    }

    public function getTotalClients(): int {
        return Client::count();
    }

}
