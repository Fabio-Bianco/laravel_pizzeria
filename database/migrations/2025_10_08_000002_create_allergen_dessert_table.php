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
        Schema::create('allergen_dessert', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dessert_id')->constrained()->onDelete('cascade');
            $table->foreignId('allergen_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['dessert_id', 'allergen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergen_dessert');
    }
};
