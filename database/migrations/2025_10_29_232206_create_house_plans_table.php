<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('house_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->unsignedInteger('surface_area'); // en m²
            $table->unsignedTinyInteger('floors'); // Nombre d'étages
            $table->unsignedTinyInteger('bedrooms');
            $table->unsignedTinyInteger('bathrooms');
            $table->decimal('price', 10, 2);
            $table->string('image_path'); // Image de présentation
            $table->string('plan_2d_path')->nullable(); // Plan 2D
            $table->string('panorama_image_path')->nullable(); // Image pour visite virtuelle 360°
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_plans');
    }
};
