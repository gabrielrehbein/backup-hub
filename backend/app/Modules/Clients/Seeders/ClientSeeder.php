<?php

namespace App\Modules\Clients\Seeders;

use App\Modules\Clients\Models\Client;
use App\Shared\Security\Actions\UuidApiKeyWithIdentifierGenerator;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::create([
            'name' => 'Super Mercado Joaozinho',
            'external_id' => "1",
            "plan_id" => 1,
            "api_key" => UuidApiKeyWithIdentifierGenerator::execute()->hashedApiKey
        ]);

        Client::create([
            'name' => 'Auto Peças Beder',
            'external_id' => "232",
            "plan_id" => 1,
            "api_key" => UuidApiKeyWithIdentifierGenerator::execute()->hashedApiKey
        ]);

        Client::create([
            'name' => 'Contabilidade dos Marcos',
            'external_id' => "32",
            "plan_id" => 2,
            "api_key" => UuidApiKeyWithIdentifierGenerator::execute()->hashedApiKey
        ]);
    }
}

