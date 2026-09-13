<?php

namespace App\Modules\Systems\Http\Controllers;


use App\Modules\Systems\Contracts\Services\SystemInstanceServiceInterface;
use App\Modules\Systems\Http\Requests\StoreSystemRequest;
use App\Modules\Systems\DTOs\CreateSystemInstanceDTO;
use App\Modules\Systems\DTOs\UpdateSystemInstanceDTO;
use App\Modules\Systems\Http\Requests\StoreSystemInstanceRequest;
use App\Modules\Systems\Http\Requests\UpdateSystemRequest;
use App\Modules\Systems\Http\Resources\PublicInstanceResource;
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
        $instances = $this->systemInstanceService->findAll();
        return JSONResponse::success(
            PublicInstanceResource::collection($instances),
            BuildResponseMessage::findAll(ResourceEnum::SYSTEM_INSTANCE),
            200);
    }

    public function refreshApiKey(int $id)
    {
        $apiKey = $this->systemInstanceService->refreshApiKey(
            $id
        );
        return JSONResponse::success(["new_api_key" => $apiKey], 'Api Key atualizada com sucesso');
    }

    public function store(StoreSystemInstanceRequest $request)
    {
        $system = $this->systemInstanceService->create(
            $request->toDTO()
        );
        return JSONResponse::success($system, BuildResponseMessage::create(ResourceEnum::SYSTEM_INSTANCE), 201);
    }

    public function show(string $id)
    {
        $system = $this->systemInstanceService->findById($id);
        return JSONResponse::success($system, BuildResponseMessage::findOne(ResourceEnum::SYSTEM_INSTANCE), 200);
    }


    public function update(UpdateSystemRequest $request, string $id)
    {
        $system = $this->systemInstanceService->update($request->toDTO(), $id);
        return JSONResponse::success($system, BuildResponseMessage::update(ResourceEnum::SYSTEM_INSTANCE), 200);
    }

    public function destroy(string $id)
    {
        $this->systemInstanceService->delete($id);
        return JSONResponse::success(null, BuildResponseMessage::delete(ResourceEnum::SYSTEM_INSTANCE), 204);
    }
}
