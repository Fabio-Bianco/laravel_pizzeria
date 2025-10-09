<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Rimuove i CHECK multilanguage da appetizers
        DB::statement('ALTER TABLE appetizers MODIFY name LONGTEXT NULL;');
        DB::statement('ALTER TABLE appetizers MODIFY description LONGTEXT NULL;');
        DB::statement('ALTER TABLE appetizers MODIFY manual_allergens LONGTEXT NULL;');
        // Fai lo stesso per desserts e beverages se necessario
        DB::statement('ALTER TABLE desserts MODIFY name LONGTEXT NULL;');
        DB::statement('ALTER TABLE desserts MODIFY description LONGTEXT NULL;');
        DB::statement('ALTER TABLE beverages MODIFY name LONGTEXT NULL;');
        DB::statement('ALTER TABLE beverages MODIFY description LONGTEXT NULL;');
    }

    public function down(): void
    {
        // Non ripristina i CHECK, solo struttura base
    }
};
