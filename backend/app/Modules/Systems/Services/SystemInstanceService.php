<?php

namespace App\Modules\Systems\Services;

use App\Modules\Systems\Contracts\Repositories\SystemInstanceRepositoryInterface;
use App\Modules\Systems\Contracts\Services\SystemInstanceServiceInterface;
use App\Modules\Systems\DTOs\CreateSystemInstanceDTO;
use App\Modules\Systems\DTOs\UpdateSystemInstanceDTO;
use App\Modules\Systems\Models\SystemInstance;
use App\Shared\Security\Contracts\ApiKeyGeneratorInterface;

class SystemInstanceService implements SystemInstanceServiceInterface
{
    public function __construct(
        private readonly SystemInstanceRepositoryInterface $repository,
        private readonly ApiKeyGeneratorInterface $apiKeyGenerator
    ) {}

    public function create(CreateSystemInstanceDTO $payload): SystemInstance
    {
        $apiKeyDTO = $this->apiKeyGenerator->execute();


        $payload->apiKey = $apiKeyDTO->hashedApiKey;
        $instance = $this->repository->create($payload);

        $instance->api_key = $apiKeyDTO->unhashedApiKey;
        return $instance;
    }

    public function refreshApiKey(int $id): string
    {
        $instance = $this->findById($id);

        $apiKeyDTO = $this->apiKeyGenerator->execute();

        $this->repository->refreshApiKey(
            $apiKeyDTO->hashedApiKey,
            $instance
        );

        return $apiKeyDTO->unhashedApiKey;
    }

    public function findAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function delete(int $id): bool
    {
        $system = $this->repository->findById($id);
        return $this->repository->delete($system);
    }

    public function update(UpdateSystemInstanceDTO $payload, int $id): SystemInstance
    {
        $system = $this->repository->findById($id);
        return $this->repository->update($payload, $system);
    }

    public function findById(int $id): SystemInstance
    {
        return $this->repository->findById($id);
    }
}
