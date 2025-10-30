<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer les anciennes catégories pour éviter les doublons
        \App\Models\Category::query()->delete();

        $categories = [
            ['name' => 'Conseils', 'slug' => 'conseils'],
            ['name' => 'Tendances', 'slug' => 'tendances'],
            ['name' => 'Témoignages', 'slug' => 'temoignages'],
            ['name' => 'Actualités', 'slug' => 'actualites'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
