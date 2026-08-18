<?php

namespace App\Modules\Auth\Services;

use App\Modules\Auth\Contracts\Services\AuthServiceInterface;
use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthService implements AuthServiceInterface
{
    public function login(LoginDTO $request): ?array
    {
        if (! Auth::attempt($request->toArray())) {
            return null;
        }

        $token = Auth::user()
            ->createToken("backup-hub-api")
            ->plainTextToken;

        return ['token' => $token];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
