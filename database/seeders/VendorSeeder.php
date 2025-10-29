<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création de vendeurs de test
        // Création de vendeurs de test avec des valeurs explicites pour is_active
        Vendor::create([
            'name' => 'Boutique Moderne',
            'email' => 'boutique@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => '1', // Utilisation d'une chaîne pour éviter les problèmes de type
        ]);

        Vendor::create([
            'name' => 'Tech Store',
            'email' => 'tech@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => '1', // Utilisation d'une chaîne pour éviter les problèmes de type
        ]);

        Vendor::create([
            'name' => 'Fashion Shop',
            'email' => 'fashion@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => '0', // Compte désactivé à titre d'exemple, utilisation d'une chaîne
        ]);
    }
}
