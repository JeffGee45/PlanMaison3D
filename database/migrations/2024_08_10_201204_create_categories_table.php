<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Ajouter une catégorie par défaut
        DB::table('categories')->insert([
            'name' => 'Non classé',
            'slug' => 'non-classe',
            'description' => 'Articles non classés',
            'is_active' => true,
            'order' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Supprimer d'abord la contrainte de clé étrangère dans la table products
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        
        // Puis supprimer la table categories
        Schema::dropIfExists('categories');
    }
};
