<?php

namespace App\Modules\Systems\Http\Controllers;

use App\Modules\Systems\Http\Requests\StoreSystemRequest;
use App\Modules\Systems\Contracts\Services\SystemServiceInterface;
use App\Modules\Systems\DTOs\CreateSystemDTO;
use App\Modules\Systems\DTOs\UpdateSystemDTO;
use App\Modules\Systems\Http\Requests\UpdateSystemRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use Illuminate\Http\Request;


class SystemController extends Controller
{

    public function __construct(
        private readonly SystemServiceInterface $systemService,
    ){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $systems = $this->systemService->findAll();
        return JSONResponse::success($systems, "Sistemas recuperados com sucesso");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSystemRequest $request)
    {
        $system = $this->systemService->create(CreateSystemDTO::fromArray($request->validated()));
        return JSONResponse::success($system, "Sistema criado com sucesso", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $system = $this->systemService->findById($id);
        return JSONResponse::success($system, "Sistema recuperado com sucesso");
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSystemRequest $request, string $id)
    {
        $system = $this->systemService->update(UpdateSystemDTO::fromArray($request->validated()), $id);
        return JSONResponse::success($system, "Sistema atualizado com sucesso");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->systemService->delete($id);
        return JSONResponse::success(null, "Sistema removido com sucesso", 204);
    }
}
