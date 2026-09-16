<?php

namespace App\Modules\Systems\Services;

use App\Modules\Systems\Contracts\Repositories\SystemRepositoryInterface;
use App\Modules\Systems\Contracts\Services\SystemServiceInterface;
use App\Modules\Systems\DTOs\CreateSystemDTO;
use App\Modules\Systems\DTOs\UpdateSystemDTO;
use App\Modules\Systems\Enums\SystemCategoryEnum;
use App\Modules\Systems\Models\System;


class SystemService implements SystemServiceInterface
{
    public function __construct(
        private readonly SystemRepositoryInterface $systemRepository,
    ){}

    public function create(CreateSystemDTO $payload): System
    {
        return $this->systemRepository->create($payload);
    }

    public function findAll(): iterable
    {
        return $this->systemRepository->findAll();
    }

    public function delete(int $id): bool
    {
        $system = $this->findById($id);
        return $this->systemRepository->delete($system);
    }

    public function update(UpdateSystemDTO $payload, int $id): System
    {
        $system = $this->findById($id);
        return $this->systemRepository->update($payload, $system);
    }

    public function findById(int $id): System
    {
        return $this->systemRepository->findById($id);
    }

    public function findByCategory(int $categoryId): iterable
    {
        return $this->systemRepository->findByCategory($categoryId);
    }
}
