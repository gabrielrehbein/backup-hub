<?php

namespace App\Modules\Systems\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Modules\Systems\Models\System;
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
        Gate::authorize('viewAny', System::class);
        $systems = $this->systemService->findAll();
        return JSONResponse::success($systems, BuildResponseMessage::findAll(ResourceEnum::SYSTEM), 200);
    }

    public function store(StoreSystemRequest $request)
    {
        Gate::authorize('create', System::class);
        $system = $this->systemService->create(
            $request->toDTO()
        );
        return JSONResponse::success($system, BuildResponseMessage::create(ResourceEnum::SYSTEM), 201);
    }


    public function show(string $id)
    {
        Gate::authorize('view', System::class);
        $system = $this->systemService->findById($id);
        return JSONResponse::success($system, BuildResponseMessage::findOne(ResourceEnum::SYSTEM), 200);
    }


    public function update(UpdateSystemRequest $request, string $id)
    {
        Gate::authorize('update', System::class);
        $system = $this->systemService->update($request->toDTO(), $id);
        return JSONResponse::success($system, BuildResponseMessage::update(ResourceEnum::SYSTEM), 200);
    }


    public function destroy(string $id)
    {
        Gate::authorize('delete', System::class);
        $this->systemService->delete($id);
        return JSONResponse::success(null, BuildResponseMessage::delete(ResourceEnum::SYSTEM), 204);
    }
}
