<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("slug")->unique();
            $table->longText("description");
            $table->integer("prix");
            $table->decimal("surface", 8, 2);
            $table->integer("nombre_pieces");
            $table->integer("nombre_chambres");
            $table->integer("nombre_salles_bain");
            $table->integer("etage")->nullable();
            $table->string("adresse");
            $table->string("ville");
            $table->string("code_postal");
            $table->enum("statut", ["disponible", "vendu", "loué"])->default("disponible");
            $table->enum("type", ["vente", "location"]);
            $table->boolean("is_featured")->default(false);
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
