<?php

namespace App\Modules\Risks\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Modules\Risks\Models\Risk;
use App\Modules\Risks\Contracts\Services\RiskServiceInterface;
use App\Modules\Risks\DTOs\CreateRiskDTO;
use App\Modules\Risks\DTOs\UpdateRiskConfigDTO;
use App\Modules\Risks\Http\Requests\StoreRiskRequest;
use App\Modules\Risks\Http\Requests\UpdateRiskRequest;
use App\Shared\Http\Controllers\Controller;
use App\Shared\Http\Responses\JSONResponse;
use App\Shared\Utils\BuildResponseMessage;
use App\Shared\Utils\ResourceEnum;


class RiskController extends Controller
{
    public function __construct(public readonly RiskServiceInterface $riskService) {}

    public function index()
    {
        Gate::authorize('viewAny', Risk::class);
        $risks = $this->riskService->findAll();
        return JSONResponse::success($risks, BuildResponseMessage::findAll(ResourceEnum::RISK), 200);
    }

    public function show(int $id)
    {
        Gate::authorize('view', Risk::class);
        $risk = $this->riskService->findById($id);

        return JSONResponse::success($risk, BuildResponseMessage::findOne(ResourceEnum::RISK), 200);
    }

    public function store(StoreRiskRequest $request)
    {
        Gate::authorize('create', Risk::class);
        $risk = $this->riskService->create(
            $request->toDTO()
        );

        return JSONResponse::success($risk, BuildResponseMessage::create(ResourceEnum::RISK), 201);
    }

    public function update(UpdateRiskRequest $request, int $id)
    {
        Gate::authorize('update', Risk::class);
        $risk = $this->riskService->update(
            $request->toDTO(),
            $id
        );

        return JSONResponse::success($risk, BuildResponseMessage::update(ResourceEnum::RISK), 200);
    }

    public function destroy(int $id)
    {
        Gate::authorize('delete', Risk::class);
        $this->riskService->delete($id);

        return JSONResponse::success(null, BuildResponseMessage::delete(ResourceEnum::RISK), 204);
    }

    public function listByPlan(int $planId)
    {
        Gate::authorize('viewAny', Risk::class);
        $risks = $this->riskService->findByPlan($planId);

        return JSONResponse::success($risks, 'Riscos por plano listados com sucesso', 200);
    }
}
