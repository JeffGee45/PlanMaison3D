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
        Schema::table('house_plans', function (Blueprint $table) {
            $table->string('style')->after('slug')->nullable()->comment('Style de la maison, ex: moderne, traditionnel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('house_plans', function (Blueprint $table) {
            $table->dropColumn('style');
        });
    }
};
