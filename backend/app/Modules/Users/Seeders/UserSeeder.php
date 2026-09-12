<?php

namespace App\Modules\Users\Seeders;

use App\Modules\Users\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'ADMIN',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'phone' => '51999999999',
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Usuário',
            'email' => 'usuario@usuario.com',
            'password' => 'usuario',
            'phone' => '51988888888',
            'role' => 'default'
        ]);
    }
}
