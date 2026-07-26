<?php

namespace App\Modules\Clients\Contracts\Services;

use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\DTOs\UpdatePlanDTO;
use App\Modules\Clients\Models\Plan;

interface PlanServiceInterface
{
    public function create(CreatePlanDTO $payload): Plan;

    /**
     * @return iterable<Plan>
     */
    public function findAll(): iterable;
    public function delete(int $id): bool;
    public function update(UpdatePlanDTO $payload, int $id): Plan;
    public function findById(int $id): Plan;
}
