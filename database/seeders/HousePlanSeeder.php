<?php

namespace Database\Seeders;

use App\Models\HousePlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HousePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HousePlan::create([
            'name' => 'Villa Moderne R+1',
            'slug' => Str::slug('Villa Moderne R+1'),
            'description' => 'Une magnifique villa moderne avec un étage, idéale pour une famille. Espaces ouverts et lumineux.',
            'surface_area' => 150,
            'floors' => 1,
            'bedrooms' => 4,
            'bathrooms' => 2,
            'price' => 2500.00,
            'image_path' => 'img/Maison_1.jpg',
            'plan_2d_path' => 'img/M10.jpg',
            'panorama_image_path' => 'img/Maison3.jpg',
            'is_published' => true, // Assurez-vous que c'est bien à true pour que le plan soit visible
        ]);

        HousePlan::create([
            'name' => 'Maison Familiale Traditionnelle',
            'slug' => Str::slug('Maison Familiale Traditionnelle'),
            'description' => 'Une maison familiale chaleureuse avec un grand jardin. Parfait pour les familles nombreuses.',
            'surface_area' => 180,
            'floors' => 0, // Plain-pied
            'bedrooms' => 5,
            'bathrooms' => 3,
            'price' => 2800.00,
            'image_path' => 'img/Maison3.jpg',
            'plan_2d_path' => 'img/M11.jpg',
            'panorama_image_path' => 'img/Maison5.jpg',
            'is_published' => true, // Assurez-vous que c'est bien à true pour que le plan soit visible
        ]);

        HousePlan::create([
            'name' => 'Duplex Urbain R+2',
            'slug' => Str::slug('Duplex Urbain R+2'),
            'description' => 'Un duplex moderne sur deux étages, optimisé pour les espaces urbains. Vue imprenable depuis le toit-terrasse.',
            'surface_area' => 120,
            'floors' => 2,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'price' => 3200.00,
            'image_path' => 'img/Maison5.jpg',
            'plan_2d_path' => 'img/M12.jpg',
            'panorama_image_path' => 'img/M6.jpg',
            'is_published' => true, // Assurez-vous que c'est bien à true pour que le plan soit visible
        ]);
    }
}
