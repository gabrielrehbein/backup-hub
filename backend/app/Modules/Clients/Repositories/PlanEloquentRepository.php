<?php

namespace App\Modules\Clients\Repositories;

use App\Modules\Clients\Contracts\Repositories\PlanRepositoryInterface;
use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\DTOs\UpdatePlanDTO;
use App\Modules\Clients\Models\Plan;
use Override;

class PlanEloquentRepository implements PlanRepositoryInterface
{
    public function create(CreatePlanDTO $payload): Plan {
        return Plan::create($payload->toArray());
    }
    public function findAll(): iterable {
        return Plan::all();
    }

    public function delete(Plan $plan): bool {
        return $plan->delete();
    }

    public function update(UpdatePlanDTO $payload, Plan $plan): Plan {
        $plan->fill(
            $payload->toArray()
        );
        if($plan->isDirty()){
            $plan->save();
        }
        return $plan;
    }
    public function findById(int $id): Plan {
        return Plan::findOrFail($id);
    }

    public function findByName(string $name): Plan | null
    {
        return Plan::firstWhere('name', $name);
    }
}
