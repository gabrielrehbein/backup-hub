<?php

namespace App\Modules\Systems\Http\Controllers;

use App\Modules\Systems\Contracts\Services\SystemInstanceServiceInterface;
use App\Modules\Systems\Http\Requests\StoreSystemRequest;
use App\Modules\Systems\Contracts\Services\SystemServiceInterface;
use App\Modules\Systems\DTOs\CreateSystemInstanceDTO;
use App\Modules\Systems\DTOs\UpdateSystemInstanceDTO;
use App\Modules\Systems\Http\Requests\UpdateSystemRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Http\Request;


class SystemInstanceController extends Controller
{

    public function __construct(
        private readonly SystemInstanceServiceInterface $systemInstanceService,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $systems = $this->systemInstanceService->findAll();
        return JSONResponse::success($systems, "Sistemas recuperados com sucesso");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSystemRequest $request)
    {
        $system = $this->systemInstanceService->create(CreateSystemInstanceDTO::fromArray($request->validated()));
        return JSONResponse::success($system, "Sistema criado com sucesso", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $system = $this->systemInstanceService->findById($id);
        return JSONResponse::success($system, "Sistema recuperado com sucesso");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSystemRequest $request, string $id)
    {
        $system = $this->systemInstanceService->update(UpdateSystemInstanceDTO::fromArray($request->validated()), $id);
        return JSONResponse::success($system, "Sistema atualizado com sucesso");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->systemInstanceService->delete($id);
        return JSONResponse::success(null, "Sistema removido com sucesso", 204);
    }
}
