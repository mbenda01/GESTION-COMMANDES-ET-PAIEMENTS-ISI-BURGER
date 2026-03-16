<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@isiburger.com'],
            [
                'name'     => 'Admin ISI',
                'password' => Hash::make('password'),
                'role'     => 'Gestionnaire',
            ]
        );
        $admin->assignRole('Gestionnaire');

        $client = User::firstOrCreate(
            ['email' => 'client@isiburger.com'],
            [
                'name'     => 'Client Test',
                'password' => Hash::make('password'),
                'role'     => 'Client',
            ]
        );
        $client->assignRole('Client');
    }
}
