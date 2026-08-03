<?php

namespace App\Modules\Systems\Contracts\Services;

use App\Modules\Systems\DTOs\CreateSystemInstanceDTO;
use App\Modules\Systems\DTOs\UpdateSystemInstanceDTO;
use App\Modules\Systems\Models\SystemInstance;

interface SystemInstanceServiceInterface
{
    public function create(CreateSystemInstanceDTO $payload): SystemInstance;
    public function findAll(): iterable;
    public function delete(int $id): bool;
    public function update(UpdateSystemInstanceDTO $payload, int $id): SystemInstance;
    public function findById(int $id): SystemInstance;
}
