<?php

use App\Modules\Clients\Models\Client;
use App\Modules\Clients\Models\Plan;

use function PHPUnit\Framework\isReadable;


it("can list clients", function() {
    $response = $this->getJson("api/clients");
    $response->assertOk();
});

it("can create client", function() {
    $plan = Plan::factory()->create();
    $response = $this->postJson("api/clients", [
        "name" => "Cliente Teste",
        "plan_id" => $plan->id,
        "external_id" => "2e21d1qd",
    ]);
    $response->assertCreated();
});

it("can show client", function(){
    $client = Client::factory()->create();
    $response = $this->getJson("api/clients/" . $client->id);
    $response->assertOk();
});

it("can delete client", function() {
    $client = Client::factory()->create();
    $response = $this->deleteJson("api/clients/" . $client->id);
    $response->assertNoContent();
});

it("can edit client", function() {
    $client = Client::factory()->create();
    $response = $this->patchJson("api/clients/" . $client->id);
    $response->assertOk();
});

it("can refresh client api key", function() {
    $client = Client::factory()->create();
    $response = $this->patchJson("api/clients/" . $client->id . "/api-key/refresh");


    $response->assertJsonStructure([
    'message',
    'data' => [
        'new_api_key',
    ],
]);
});
