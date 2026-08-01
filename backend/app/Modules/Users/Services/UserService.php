<?php

namespace App\Modules\Users\Services;

use App\Modules\Users\Contracts\Repositories\UserRepositoryInterface;
use App\Modules\Users\Contracts\Services\UserServiceInterface;
use App\Modules\Users\DTOs\CreateUserDTO;
use App\Modules\Users\DTOs\UpdateUserDTO;
use App\Modules\Users\Models\User;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function create(CreateUserDTO $payload): User
    {
        return $this->userRepository->create($payload);
    }

    public function findAll(): iterable
    {
        return $this->userRepository->findAll();
    }

    public function delete(int $id): bool
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->delete($user);
    }

    public function update(UpdateUserDTO $payload, int $id): User
    {
        $user = $this->userRepository->findById($id);

        return $this->userRepository->update($payload, $user);
    }

    public function findById(int $id): User
    {
        return $this->userRepository->findById($id);
    }
}
