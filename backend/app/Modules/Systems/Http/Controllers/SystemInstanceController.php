<?php

namespace App\Modules\Systems\Http\Controllers;

use App\Modules\Systems\Contracts\Services\SystemInstanceServiceInterface;
use App\Modules\Systems\Http\Requests\StoreSystemRequest;
use App\Modules\Systems\DTOs\CreateSystemInstanceDTO;
use App\Modules\Systems\DTOs\UpdateSystemInstanceDTO;
use App\Modules\Systems\Http\Requests\UpdateSystemRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;


class SystemInstanceController extends Controller
{

    public function __construct(
        private readonly SystemInstanceServiceInterface $systemInstanceService,
    ){}

    public function index()
    {
        $systems = $this->systemInstanceService->findAll();
        return JSONResponse::success($systems, BuildResponseMessage::findAll(ResourceEnum::SYSTEM_INSTANCE), 200);
    }

    public function store(StoreSystemRequest $request)
    {
        $system = $this->systemInstanceService->create(CreateSystemInstanceDTO::fromArray($request->validated()));
        return JSONResponse::success($system, BuildResponseMessage::create(ResourceEnum::SYSTEM_INSTANCE), 201);
    }

    public function show(string $id)
    {
        $system = $this->systemInstanceService->findById($id);
        return JSONResponse::success($system, BuildResponseMessage::findOne(ResourceEnum::SYSTEM_INSTANCE), 200);
    }


    public function update(UpdateSystemRequest $request, string $id)
    {
        $system = $this->systemInstanceService->update(UpdateSystemInstanceDTO::fromArray($request->validated()), $id);
        return JSONResponse::success($system, BuildResponseMessage::update(ResourceEnum::SYSTEM_INSTANCE), 200);
    }

    public function destroy(string $id)
    {
        $this->systemInstanceService->delete($id);
        return JSONResponse::success(null, BuildResponseMessage::delete(ResourceEnum::SYSTEM_INSTANCE), 204);
    }
}
