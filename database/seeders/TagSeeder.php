<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer les anciens tags pour éviter les doublons
        \App\Models\Tag::query()->delete();

        $tags = [
            ['name' => 'Optimisation', 'slug' => 'optimisation'],
            ['name' => 'Design', 'slug' => 'design'],
            ['name' => 'Écologie', 'slug' => 'ecologie'],
            ['name' => 'Construction', 'slug' => 'construction'],
            ['name' => 'Rénovation', 'slug' => 'renovation'],
        ];

        foreach ($tags as $tag) {
            \App\Models\Tag::create($tag);
        }
    }
}
