<?php

namespace App\Modules\Users\Http\Controllers;

use App\Modules\Users\Contracts\Services\UserServiceInterface;
use App\Modules\Users\DTOs\CreateUserDTO;
use App\Modules\Users\DTOs\UpdateUserDTO;
use App\Modules\Users\Http\Requests\StoreUserRequest;
use App\Modules\Users\Http\Requests\UpdateUserRequest;
use App\Shared\Http\Responses\JSONResponse;


class UserController
{

    public function __construct(
        protected UserServiceInterface  $userService
    ) {}

    public function index()
    {
        $users = $this->userService->findAll();
        return JSONResponse::success($users, 'Usuários recuperados com sucesso');
    }


    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->create(CreateUserDTO::fromArray($request->validated()));
        return JSONResponse::success($user, 'Usuário criado com sucesso', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->findById($id);
        return JSONResponse::success($user, 'Usuário recuperado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userService->update(UpdateUserDTO::fromArray($request->validated()), $id);
        return JSONResponse::success($user, 'Usuário atualizado com sucesso');
    }

    public function destroy(string $id)
    {
        $this->userService->delete($id);
        return JSONResponse::success(null, 'Usuário deletado com sucesso', 204);
    }
}
