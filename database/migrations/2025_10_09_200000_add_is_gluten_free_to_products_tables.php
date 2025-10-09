<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('pizzas', 'is_gluten_free')) {
            Schema::table('pizzas', function (Blueprint $table) {
                $table->boolean('is_gluten_free')->default(false)->after('is_vegan');
            });
        }
        if (!Schema::hasColumn('appetizers', 'is_gluten_free')) {
            Schema::table('appetizers', function (Blueprint $table) {
                $table->boolean('is_gluten_free')->default(false)->after('is_vegan');
            });
        }
        if (!Schema::hasColumn('desserts', 'is_gluten_free')) {
            Schema::table('desserts', function (Blueprint $table) {
                $table->boolean('is_gluten_free')->default(false)->after('is_vegan');
            });
        }
        if (!Schema::hasColumn('beverages', 'is_gluten_free')) {
            Schema::table('beverages', function (Blueprint $table) {
                $table->boolean('is_gluten_free')->default(false)->after('is_vegan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pizzas', 'is_gluten_free')) {
            Schema::table('pizzas', function (Blueprint $table) {
                $table->dropColumn('is_gluten_free');
            });
        }
        if (Schema::hasColumn('appetizers', 'is_gluten_free')) {
            Schema::table('appetizers', function (Blueprint $table) {
                $table->dropColumn('is_gluten_free');
            });
        }
        if (Schema::hasColumn('desserts', 'is_gluten_free')) {
            Schema::table('desserts', function (Blueprint $table) {
                $table->dropColumn('is_gluten_free');
            });
        }
        if (Schema::hasColumn('beverages', 'is_gluten_free')) {
            Schema::table('beverages', function (Blueprint $table) {
                $table->dropColumn('is_gluten_free');
            });
        }
    }
};
