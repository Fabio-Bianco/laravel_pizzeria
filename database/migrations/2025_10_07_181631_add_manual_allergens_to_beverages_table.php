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
        Schema::table('beverages', function (Blueprint $table) {
            $table->json('manual_allergens')->nullable()->after('description')->comment('Allergeni aggiunti manualmente (array di ID allergeni)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beverages', function (Blueprint $table) {
            $table->dropColumn('manual_allergens');
        });
    }
};
