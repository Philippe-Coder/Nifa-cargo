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
            ['email' => 'admin@nifacargo.com'],
            [
                'name' => 'Administrateur NIF CARGO',
                'email' => 'admin@nifacargo.com',
                'telephone' => '+22890000000',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Créer un deuxième admin avec un autre email
        User::firstOrCreate(
            ['email' => 'philippe@nifacargo.com'],
            [
                'name' => 'Philippe Admin',
                'email' => 'philippe@nifacargo.com',
                'telephone' => '+22890000001',
                'password' => Hash::make('admin2024'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Créer un utilisateur client de test
        User::firstOrCreate(
            ['email' => 'client@nifacargo.com'],
            [
                'name' => 'Client Test',
                'email' => 'client@nifacargo.com',
                'telephone' => '+22890111111',
                'password' => Hash::make('client123'),
                'role' => 'client',
                'email_verified_at' => now(),
            ]
        );

        // Créer un autre client de test
        User::firstOrCreate(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Client Gmail Test',
                'email' => 'test@gmail.com',
                'telephone' => '+22890111222',
                'password' => Hash::make('test123'),
                'role' => 'client',
                'email_verified_at' => now(),
            ]
        );
    }
}
