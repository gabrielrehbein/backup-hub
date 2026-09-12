<?php

namespace App\Modules\Risks\Seeders;

use App\Modules\Clients\Models\Plan;
use App\Modules\Risks\Models\Risk;
use Illuminate\Database\Seeder;

class RiskSeeder extends Seeder
{
    public function run(): void
    {
        Risk::create([
            'name' => 'Baixo',
            'level' => 1,
            'description' => 'Risco baixo, com impacto mínimo e baixa probabilidade de ocorrência.',
            'notifiable' => true,
            'max_delay_limit_in_minutes' => '3000',
            'max_size_loss_in_percent' => 20,
            'plan_id' => 1
        ]);

        Risk::create([
            'name' => 'Medio',
            'level' => 5,
            'description' => 'Risco médio, com impacto moderado e probabilidade de ocorrência razoável.',
            'notifiable' => true,
            'max_delay_limit_in_minutes' => '2000',
            'max_size_loss_in_percent' => 10,
            'plan_id' => 1
        ]);

        Risk::create([
            'name' => 'Alto',
            'level' => 1,
            'notifiable' => true,
            'description' => 'Risco alto, com impacto significativo e alta probabilidade de ocorrência.',
            'max_delay_limit_in_minutes' => '1000',
            'max_size_loss_in_percent' => 5,
            'plan_id' => 1
        ]);


        Risk::create([
            'name' => 'Baixo',
            'level' => 1,
            'notifiable' => true,
            'description' => 'Risco baixo, com impacto mínimo e baixa probabilidade de ocorrência.',
            'max_delay_limit_in_minutes' => '3000',
            'max_size_loss_in_percent' => 20,
            'plan_id' => 2
        ]);

        Risk::create([
            'name' => 'Medio',
            'level' => 5,
            'notifiable' => true,
            'description' => 'Risco médio, com impacto moderado e probabilidade de ocorrência razoável.',
            'max_delay_limit_in_minutes' => '2000',
            'max_size_loss_in_percent' => 10,
            'plan_id' => 2
        ]);

        Risk::create([
            'name' => 'Alto',
            'level' => 1,
            'notifiable' => true,
            'description' => 'Risco alto, com impacto significativo e alta probabilidade de ocorrência.',
            'max_delay_limit_in_minutes' => '1000',
            'max_size_loss_in_percent' => 5,
            'plan_id' => 2
        ]);
    }
}


