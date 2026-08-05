<?php

use App\Modules\Clients\Models\Plan;

it('can list plans', function () {
    $response = $this->getJson('/api/plans');
    $response->assertOk();
});

it('can create plan', function () {
    $response = $this->postJson('/api/plans', [
        "name" => "Plano Teste",
        "description" => "Descrição do plano teste",
    ]);
    $response->assertCreated();
});

it('can show plan', function () {
    $plan = Plan::factory()->create();
    $response = $this->getJson('/api/plans/' . $plan->id);
    $response->assertOk();
});

it('can edit plan', function () {
    $plan = Plan::factory()->create();
    $response = $this->patchJson('/api/plans/' . $plan->id, [
        "name" => "Plano Teste Editado",
        "description" => "Descrição do plano teste editado",
    ]);
    $response->assertOk();
});

it("can delete plan", function(){
    $plan = Plan::factory()->create();
    $response = $this->deleteJson('/api/plans/' . $plan->id);
    $response->assertNoContent();
});
