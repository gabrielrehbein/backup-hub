<?php

namespace App\Modules\Users\Http\Controllers;

use App\Modules\Users\Contracts\Services\UserServiceInterface;
use App\Modules\Users\Http\Requests\StoreUserRequest;
use App\Modules\Users\Http\Requests\UpdateUserRequest;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;
use Illuminate\Http\Request;


class UserController
{

    public function __construct(
        protected UserServiceInterface  $userService
    ) {}

    public function index()
    {
        $users = $this->userService->findAll();
        return JSONResponse::success($users, BuildResponseMessage::findAll(ResourceEnum::USER), 200);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return JSONResponse::success($user, BuildResponseMessage::findOne(ResourceEnum::USER), 200);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->create(
            $request->toDTO()
        );
        return JSONResponse::success($user, BuildResponseMessage::create(ResourceEnum::USER), 201);
    }

    public function show(string $id)
    {
        $user = $this->userService->findById($id);
        return JSONResponse::success($user, BuildResponseMessage::findOne(ResourceEnum::USER), 200);
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userService->update(
            $request->toDTO(),
            $id
        );
        return JSONResponse::success($user, BuildResponseMessage::update(ResourceEnum::USER), 200);
    }

    public function destroy(string $id)
    {
        $this->userService->delete($id);
        return JSONResponse::success(null, BuildResponseMessage::delete(ResourceEnum::USER), 204);
    }
}
