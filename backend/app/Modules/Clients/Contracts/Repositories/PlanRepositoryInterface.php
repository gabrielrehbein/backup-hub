<?php

namespace App\Modules\Clients\Contracts\Repositories;

use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\DTOs\UpdatePlanDTO;
use App\Modules\Clients\Models\Plan;

interface PlanRepositoryInterface
{
    public function create(CreatePlanDTO $payload): Plan;
    public function findAll(): iterable;
    public function delete(Plan $plan): bool;
    public function update(UpdatePlanDTO $payload, Plan $plan): Plan;
    public function findById(int $id): Plan;
    public function findByName(string $name): Plan | null;
}
