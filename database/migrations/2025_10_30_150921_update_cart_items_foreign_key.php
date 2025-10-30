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
        Schema::table('cart_items', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte de clé étrangère
            $table->dropForeign(['product_id']);
            
            // Ajouter la nouvelle contrainte de clé étrangère vers house_plans
            $table->foreign('product_id')
                  ->references('id')
                  ->on('house_plans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère vers house_plans
            $table->dropForeign(['product_id']);
            
            // Rétablir l'ancienne contrainte de clé étrangère vers products
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }
};
