<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Deduplica nomi duplicati apponendo suffissi incrementali prima di aggiungere l'unico
        $names = DB::table('pizzas')
            ->select('name', DB::raw('COUNT(*) as cnt'))
            ->groupBy('name')
            ->having('cnt', '>', 1)
            ->pluck('name');

        foreach ($names as $name) {
            $rows = DB::table('pizzas')->where('name', $name)->orderBy('id')->get();
            $i = 1;
            foreach ($rows as $row) {
                if ($i === 1) { $i++; continue; }
                DB::table('pizzas')->where('id', $row->id)->update(['name' => $name.' ('.$i.')']);
                $i++;
            }
        }

        Schema::table('pizzas', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }
};
