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
        // Supprimer les anciens utilisateurs pour éviter les doublons
        User::query()->delete();

        // Créer un administrateur
        User::create([
            'name' => 'Admin',
            'email' => 'admin@planmaison3d.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Créer 5 utilisateurs de test
        User::factory(5)->create();
    }
}
