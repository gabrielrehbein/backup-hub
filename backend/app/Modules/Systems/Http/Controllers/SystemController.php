<?php

namespace App\Modules\Systems\Http\Controllers;

use App\Modules\Systems\Http\Requests\StoreSystemRequest;
use App\Modules\Systems\Contracts\Services\SystemServiceInterface;
use App\Modules\Systems\DTOs\CreateSystemDTO;
use App\Modules\Systems\DTOs\UpdateSystemDTO;
use App\Modules\Systems\Http\Requests\UpdateSystemRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;
use Illuminate\Http\Request;


class SystemController extends Controller
{

    public function __construct(
        private readonly SystemServiceInterface $systemService,
    ){}

    public function index()
    {
        $systems = $this->systemService->findAll();
        return JSONResponse::success($systems, BuildResponseMessage::findAll(ResourceEnum::SYSTEM), 200);
    }

    public function store(StoreSystemRequest $request)
    {
        $system = $this->systemService->create(CreateSystemDTO::fromArray($request->validated()));
        return JSONResponse::success($system, BuildResponseMessage::create(ResourceEnum::SYSTEM), 201);
    }


    public function show(string $id)
    {
        $system = $this->systemService->findById($id);
        return JSONResponse::success($system, BuildResponseMessage::findOne(ResourceEnum::SYSTEM), 200);
    }


    public function update(UpdateSystemRequest $request, string $id)
    {
        $system = $this->systemService->update(UpdateSystemDTO::fromArray($request->validated()), $id);
        return JSONResponse::success($system, BuildResponseMessage::update(ResourceEnum::SYSTEM), 200);
    }


    public function destroy(string $id)
    {
        $this->systemService->delete($id);
        return JSONResponse::success(null, BuildResponseMessage::delete(ResourceEnum::SYSTEM), 204);
    }
}
