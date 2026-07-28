<?php

namespace App\Modules\Users\Contracts\Repositories;

use App\Modules\Users\DTOs\CreateUserDTO;
use App\Modules\Users\DTOs\UpdateUserDTO;
use App\Modules\Users\Models\User;

interface UserRepositoryInterface
{
    public function create(CreateUserDTO $payload): User;
    public function findAll(): iterable;
    public function delete(User $client): bool;
    public function update(UpdateUserDTO $payload, User $client): User;
    public function findById(int $id): User;
}
