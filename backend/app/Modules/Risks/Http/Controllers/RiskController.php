<?php

namespace App\Modules\Risks\Http\Controllers;

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
        $risks = $this->riskService->findAll();

        return JSONResponse::success($risks, BuildResponseMessage::findAll(ResourceEnum::RISK), 200);
    }

    public function show(int $id)
    {
        $risk = $this->riskService->findById($id);

        return JSONResponse::success($risk, BuildResponseMessage::findOne(ResourceEnum::RISK), 200);
    }

    public function store(StoreRiskRequest $request)
    {
        $risk = $this->riskService->create(
            CreateRiskDTO::fromArray($request->toArray())
        );

        return JSONResponse::success($risk, BuildResponseMessage::create(ResourceEnum::RISK), 201);
    }

    public function update(UpdateRiskRequest $request, int $id)
    {
        $risk = $this->riskService->update(
            UpdateRiskConfigDTO::fromArray($request->toArray()),
            $id
        );

        return JSONResponse::success($risk, BuildResponseMessage::update(ResourceEnum::RISK), 200);
    }

    public function destroy(int $id)
    {
        $this->riskService->delete($id);

        return JSONResponse::success(null, BuildResponseMessage::delete(ResourceEnum::RISK), 204);
    }

    public function listByPlan(int $planId)
    {
        $risks = $this->riskService->findByPlan($planId);

        return JSONResponse::success($risks, 'Riscos por plano listados com sucesso', 200);
    }
}
