<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création d'un utilisateur admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Création de quelques utilisateurs de test
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Marie Martin',
            'email' => 'marie.martin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'user',
        ]);
    }
}
