<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer les anciens articles pour éviter les doublons
        \App\Models\Post::query()->delete();

        // S'assurer que le dossier existe
        $path = storage_path('app/public/posts');
        if (!\Illuminate\Support\Facades\File::isDirectory($path)) {
            \Illuminate\Support\Facades\File::makeDirectory($path, 0777, true, true);
        }

        $faker = \Faker\Factory::create();

        // Récupérer l'admin, les catégories et les tags
        $admin = \App\Models\User::where('role', 'admin')->first();
        $categories = \App\Models\Category::all();
        $tags = \App\Models\Tag::all();

        for ($i = 0; $i < 15; $i++) {
            $title = $faker->sentence;
            $post = \App\Models\Post::create([
                'title' => $title,
                'slug' => \Illuminate\Support\Str::slug($title),
                'content' => $faker->paragraphs(5, true),
                'image' => 'posts/' . $faker->image('public/storage/posts', 640, 480, null, false),
                'status' => $faker->randomElement(['published', 'draft']),
                'user_id' => $admin->id,
                'category_id' => $categories->random()->id,
            ]);

            // Attacher des tags aléatoires
            $post->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        }
    }
}
