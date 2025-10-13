<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur admin par défaut
        User::firstOrCreate(
            ['email' => 'admin@nif.com'],
            [
                'name' => 'Administrateur NIF CARGO',
                'email' => 'admin@nif.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Créer un utilisateur client de test
        User::firstOrCreate(
            ['email' => 'client@nif.com'],
            [
                'name' => 'Client Test',
                'email' => 'client@nif.com',
                'password' => Hash::make('client123'),
                'role' => 'client',
                'email_verified_at' => now(),
            ]
        );
    }
}
