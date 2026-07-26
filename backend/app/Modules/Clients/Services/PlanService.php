<?php

namespace App\Modules\Clients\Services;

use App\Modules\Clients\Contracts\Repositories\PlanRepositoryInterface;
use App\Modules\Clients\Contracts\Services\PlanServiceInterface;
use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\DTOs\UpdatePlanDTO;
use App\Modules\Clients\Models\Plan;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PlanService implements PlanServiceInterface
{
    public function __construct(readonly private PlanRepositoryInterface $planRepository){}


    public function create(CreatePlanDTO $payload): Plan {
        return $this->planRepository->create($payload);
    }

    public function findAll(): iterable {
        return $this->planRepository->findAll();
    }

    public function delete(int $id): bool {
        $plan = $this->findById($id);
        return $this->planRepository->delete($plan);
    }

    public function update(UpdatePlanDTO $payload, int $id): Plan {
        $plan = $this->findById($id);
        return $this->planRepository->update($payload, $plan);
    }

    public function findById(int $id): Plan {
        return $this->planRepository->findById($id);
    }
}
