<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création de coupons de test
        Coupon::create([
            'code' => 'WELCOME10',
            'name' => 'Bienvenue',
            'description' => 'Réduction de bienvenue de 10%',
            'type' => 'percent',
            'value' => 10.00,
            'min_cart_amount' => 50.00,
            'starts_at' => now(),
            'expires_at' => now()->addMonth(),
            'usage_limit' => 100,
            'usage_count' => 0,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SUMMER25',
            'name' => 'Été 2025',
            'description' => 'Réduction spéciale été 25%',
            'type' => 'percent',
            'value' => 25.00,
            'min_cart_amount' => 100.00,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(2),
            'usage_limit' => 50,
            'usage_count' => 5,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'EXPIRED5',
            'name' => 'Expiré',
            'description' => 'Ancien coupon de 5%',
            'type' => 'percent',
            'value' => 5.00,
            'min_cart_amount' => 20.00,
            'starts_at' => now()->subMonths(2),
            'expires_at' => now()->subMonth(),
            'usage_limit' => 100,
            'usage_count' => 100,
            'is_active' => false,
        ]);
    }
}
