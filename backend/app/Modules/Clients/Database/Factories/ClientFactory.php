<?php

namespace App\Modules\Clients\Database\Factories;

use App\Modules\Clients\Models\Client;
use App\Modules\Clients\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Plan>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->sentence(),
            "external_id" => fake()->uuid(),
            "plan_id" => Plan::factory()->create(),
            "api_key" => fake()->uuid(),
        ];
    }
}
