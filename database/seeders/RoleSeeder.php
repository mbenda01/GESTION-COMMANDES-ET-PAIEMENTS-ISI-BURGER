<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Gestionnaire', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'Client',       'guard_name' => 'web']);
    }
}
