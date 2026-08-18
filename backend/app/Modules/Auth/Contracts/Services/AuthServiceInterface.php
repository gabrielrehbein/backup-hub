<?php

namespace App\Modules\Auth\Contracts\Services;

use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Users\Models\User;

interface AuthServiceInterface
{
    public function login(LoginDTO $loginDTO): ?array;
    public function logout(User $user): void;
}
