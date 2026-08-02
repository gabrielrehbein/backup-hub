<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Contracts\Repositories\UserRepositoryInterface;
use App\Modules\Users\DTOs\CreateUserDTO;
use App\Modules\Users\DTOs\UpdateUserDTO;
use App\Modules\Users\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    public function create(CreateUserDTO $payload): User
    {
        return User::create(
            $payload->toArray()
        );
    }

    public function findAll(): iterable
    {
        return User::all();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function update(UpdateUserDTO $payload, User $user): User
    {
        $user->fill(
            $payload->toArray()
        );
        if($user->isDirty()){
            $user->save();
        }
        return $user;
    }

    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }
}
