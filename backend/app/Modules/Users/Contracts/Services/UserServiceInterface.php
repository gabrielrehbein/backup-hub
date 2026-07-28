<?php

namespace App\Modules\Users\Contracts\Services;

use App\Modules\Users\DTOs\CreateUserDTO;
use App\Modules\Users\DTOs\UpdateUserDTO;
use App\Modules\Users\Models\User;

interface UserServiceInterface
{
    public function create(CreateUserDTO $payload): User;
    public function findAll(): iterable;
    public function delete(int $id): bool;
    public function update(UpdateUserDTO $payload, int $id): User;
    public function findById(int $id): User;
}
