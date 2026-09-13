<?php

namespace App\Modules\Systems\Repositories;

use App\Modules\Systems\Contracts\Repositories\SystemInstanceRepositoryInterface;
use App\Modules\Systems\DTOs\CreateSystemInstanceDTO;
use App\Modules\Systems\DTOs\UpdateSystemInstanceDTO;
use App\Modules\Systems\Models\SystemInstance;


class SystemInstanceEloquentRepository implements SystemInstanceRepositoryInterface
{

    public function create(CreateSystemInstanceDTO $payload): SystemInstance
    {
        return SystemInstance::create($payload->toArray());
    }

    public function findAll(): iterable
    {
        return SystemInstance::all();
    }

    public function delete(SystemInstance $systemInstance): bool
    {
        return $systemInstance->delete();
    }

    public function update(UpdateSystemInstanceDTO $payload, SystemInstance $systemInstance): SystemInstance
    {
        $system = $systemInstance->fill($payload->toArray());
        if ($system->isDirty()) {
            $system->save();
        }
        return $system;
    }

    public function findById(int $id): SystemInstance
    {
        return SystemInstance::findOrFail($id);
    }

    public function findByApiKeyIdentifier(string $identifier): SystemInstance {
        return SystemInstance::firstWhere("api_key", "like", $identifier . ".%");
    }

    public function refreshApiKey(string $apiKey, SystemInstance $instance): SystemInstance {
        $instance->api_key = $apiKey;
        $instance->save();
        return $instance;
    }
}
