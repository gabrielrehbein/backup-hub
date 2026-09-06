<?php

namespace App\Shared\Http\Controllers;

use App\Shared\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Modules\Clients\DTOs\CreatePlanDTO;
use App\Modules\Clients\DTOs\CreateClientDTO;
use App\Modules\Clients\Services\ClientService;
use App\Modules\Clients\Services\PlanService as ServicesPlanService;
use App\Modules\Systems\DTOs\CreateSystemDTO;
use App\Modules\Systems\Services\SystemInstanceService;
use App\Modules\Systems\Services\SystemService;
use App\Modules\Systems\DTOs\CreateSystemInstanceDTO;
use App\Modules\Users\Services\UserService;
use App\Modules\Users\DTOs\CreateUserDTO;

class SeederController extends Controller
{
    public function seed(
        ClientService $clientService,
        ServicesPlanService $planService,
        SystemService $systemService,
        SystemInstanceService $systemInstanceService,
        UserService $userService,
    ) {
        DB::transaction(function () use (
            $clientService,
            $planService,
            $systemService,
            $systemInstanceService,
            $userService
        ) {
            $plan = $planService->create(
                CreatePlanDTO::fromArray([
                    'name' => 'Plano Teste',
                ])
            );

            $client = $clientService->create(
                CreateClientDTO::fromArray([
                    'name' => 'Cliente Teste',
                    'external_id' => '12345',
                    'plan_id' => $plan->id,
                ])
            );

            $system = $systemService->create(
                CreateSystemDTO::fromArray([
                    'name' => 'Sistema Teste',
                    'category' => 'erp',
                ])
            );

            $systemInstanceService->create(
                CreateSystemInstanceDTO::fromArray([
                    'system_id' => $system->id,
                    'client_id' => $client->id,
                    'version' => '1.0',
                ])
            );
            $userService->create(
                CreateUserDTO::fromArray([
                    'name' => 'admin',
                    'email' => 'admin@admin.com',
                    'role' => 'admin',
                    'password' => 'admin',
                ])
            );
        });
    }
}