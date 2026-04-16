<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('biens', function (Blueprint $table) {
            $table->string('statut')->default('disponible')->change();
            $table->string('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biens', function (Blueprint $table) {
            $table->enum('statut', ['disponible', 'vendu', 'loué'])
                ->default('disponible')
                ->change();

            $table->enum('type', ['vente', 'location'])
                ->change();
        });
    }
};
