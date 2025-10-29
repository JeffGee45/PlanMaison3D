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
        Schema::table('products', function (Blueprint $table) {
            // Ajouter la colonne slug
            $table->string('slug')->after('name')->nullable();
            
            // Modifier le type de la colonne price pour utiliser decimal au lieu de integer
            $table->decimal('price', 10, 2)->change();
            
            // Renommer la colonne active en status pour plus de clarté
            $table->renameColumn('active', 'status');
            
            // Ajouter la colonne category_id
            $table->unsignedBigInteger('category_id')->nullable()->after('vendor_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            
            // Modifier la colonne description pour permettre plus de texte
            $table->text('description')->change();
            
            // Ajouter une colonne pour l'image
            $table->string('image')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Supprimer les colonnes ajoutées
            $table->dropColumn('slug');
            $table->dropColumn('image');
            
            // Rétablir le type de la colonne price
            $table->integer('price')->change();
            
            // Rétablir le nom de la colonne status
            $table->renameColumn('status', 'active');
            
            // Supprimer la clé étrangère et la colonne category_id
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
