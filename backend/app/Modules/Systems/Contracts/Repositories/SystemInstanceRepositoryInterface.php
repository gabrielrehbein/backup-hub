<?php

namespace App\Modules\Systems\Contracts\Repositories;

use App\Modules\Systems\DTOs\CreateSystemInstanceDTO;
use App\Modules\Systems\DTOs\UpdateSystemInstanceDTO;
use App\Modules\Systems\Models\SystemInstance;

interface SystemInstanceRepositoryInterface
{
    public function create(CreateSystemInstanceDTO $payload): SystemInstance;
    public function findAll(): iterable;
    public function delete(SystemInstance $system): bool;
    public function update(UpdateSystemInstanceDTO $payload, SystemInstance $system): SystemInstance;
    public function findById(int $id): SystemInstance;
}
