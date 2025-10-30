<?php

namespace Database\Seeders;

use App\Models\HousePlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class HousePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        HousePlan::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create();
        
        // Liste des images disponibles dans le dossier public/img
        $images = [
            'Maison_1.jpg',
            'Maison2.jpg',
            'Maison3.jpg',
            'Maison4.jpg',
            'Maison5.jpg',
            'M6.jpg',
            'M7.jpg',
            'M8.jpg',
            'M9.jpg',
            'M10.jpg',
            'M11.jpg',
            'M12.jpg'
        ];
        
        $styles = ['moderne', 'traditionnel', 'contemporain', 'classique', 'minimaliste'];
        
        for ($i = 0; $i < count($images); $i++) {
            $name = 'Maison ' . ($i + 1);
            $imagePath = 'img/' . $images[$i];
            
            HousePlan::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'style' => $styles[array_rand($styles)],
                'description' => $faker->realText(),
                'surface_area' => $faker->numberBetween(80, 350),
                'floors' => $faker->numberBetween(1, 3),
                'bedrooms' => $faker->numberBetween(2, 6),
                'bathrooms' => $faker->numberBetween(1, 4),
                'price' => $faker->randomFloat(2, 1500, 4000),
                'image_path' => $imagePath,
                'plan_2d_path' => 'img/M' . (($i % 6) + 10) . '.jpg', // Utilisation des images M10, M11, M12, etc.
                'panorama_image_path' => $imagePath, // Même image pour le panorama pour l'instant
                'is_published' => true,
            ]);
        }
    }
}
