<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('beverages', function (Blueprint $table) {
            if (!Schema::hasColumn('beverages', 'formato')) {
                $table->string('formato')->nullable();
            }
            if (!Schema::hasColumn('beverages', 'tipologia')) {
                $table->string('tipologia')->nullable();
            }
            if (!Schema::hasColumn('beverages', 'gradazione_alcolica')) {
                $table->float('gradazione_alcolica')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('beverages', function (Blueprint $table) {
            $table->dropColumn(['formato', 'tipologia', 'gradazione_alcolica']);
        });
    }
};
