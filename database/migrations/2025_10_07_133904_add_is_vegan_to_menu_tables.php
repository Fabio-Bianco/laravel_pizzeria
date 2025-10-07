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
        // Aggiungi campo is_vegan a tutte le tabelle del menu
        Schema::table('pizzas', function (Blueprint $table) {
            $table->boolean('is_vegan')->default(false)->after('notes');
        });
        
        Schema::table('appetizers', function (Blueprint $table) {
            $table->boolean('is_vegan')->default(false)->after('description');
        });
        
        Schema::table('desserts', function (Blueprint $table) {
            $table->boolean('is_vegan')->default(false)->after('description');
        });
        
        Schema::table('beverages', function (Blueprint $table) {
            $table->boolean('is_vegan')->default(false)->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rimuovi campo is_vegan da tutte le tabelle del menu
        $tables = ['pizzas', 'appetizers', 'desserts', 'beverages'];
        
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('is_vegan');
            });
        }
    }
};
