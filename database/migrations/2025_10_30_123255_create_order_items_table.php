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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('item_type'); // Pour le polymorphisme (ex: App\Models\HousePlan)
            $table->unsignedBigInteger('item_id'); // ID de l'élément
            $table->string('name'); // Nom du produit au moment de la commande
            $table->integer('quantity');
            $table->decimal('price', 12, 2); // Prix unitaire
            $table->decimal('total', 12, 2); // Prix total (quantity * price)
            $table->json('options')->nullable(); // Options supplémentaires (taille, couleur, etc.)
            $table->timestamps();
            
            // Index pour la relation polymorphe
            $table->index(['item_type', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
