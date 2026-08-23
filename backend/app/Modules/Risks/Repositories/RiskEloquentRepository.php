<?php

namespace App\Modules\Risks\Repositories;

use App\Modules\Clients\Models\Plan;
use App\Modules\Risks\Contracts\Repositories\RiskRepositoryInterface;
use App\Modules\Risks\DTOs\CreateRiskDTO;
use App\Modules\Risks\DTOs\UpdateRiskConfigDTO;
use App\Modules\Risks\Models\Risk;

class RiskEloquentRepository implements RiskRepositoryInterface
{
    public function findAll(): iterable
    {
        return Risk::all();
    }

    public function create(CreateRiskDTO $payload): Risk
    {
        return Risk::create($payload->toArray());
    }

    public function delete(Risk $risk): void
    {
        $risk->delete();
    }

    public function update(UpdateRiskConfigDTO $payload, Risk $risk): Risk
    {
        $risk->fill(
            $payload->toArray()
        );
        if ($risk->isDirty()) {
            $risk->save();
        }

        return $risk;
    }

    public function findById(int $id): Risk
    {
        return Risk::findOrFail($id);
    }

    public function findByPlan(int $planId): iterable
    {
        return Risk::where('plan_id', $planId)->get();
    }
}
