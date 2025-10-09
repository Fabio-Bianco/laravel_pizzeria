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
        Schema::table('pizzas', function (Blueprint $table) {
            if (!Schema::hasColumn('pizzas', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });
        Schema::table('appetizers', function (Blueprint $table) {
            if (!Schema::hasColumn('appetizers', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });
        Schema::table('beverages', function (Blueprint $table) {
            if (!Schema::hasColumn('beverages', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });
        Schema::table('desserts', function (Blueprint $table) {
            if (!Schema::hasColumn('desserts', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        Schema::table('appetizers', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        Schema::table('beverages', function (Blueprint $table) {
            $table->dropColumn('description');
        });
        Schema::table('desserts', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
