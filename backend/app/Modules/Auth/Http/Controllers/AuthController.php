<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\Contracts\Services\AuthServiceInterface;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Http\Request;

class AuthController
{
    public function __construct(
        private readonly AuthServiceInterface $authService
    ){}

    public function login(LoginRequest $request)
    {
        $loginDTO = $request->toDTO();
        $token = $this->authService->login($loginDTO);

        if(!$token) {
            return JSONResponse::error('Credenciais inválidas', 401);
        }
        return JSONResponse::success($token, 'Login bem-sucedido');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return JSONResponse::success(null, 'Logout bem-sucedido');
    }
}
