<?php

namespace App\Modules\Users\Services;

use App\Modules\Users\Contracts\Repositories\UserRepositoryInterface;
use App\Modules\Users\Contracts\Services\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

}
