<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixMultilanguageFields extends Command
{
    protected $signature = 'fix:multilanguage-fields';
    protected $description = 'Converte i campi name e description da JSON a stringa italiana semplice per appetizer, dessert e beverage';

    public function handle()
    {
        $this->fixTable('appetizers');
        $this->fixTable('desserts');
        $this->fixTable('beverages');
        $this->info('Conversione completata.');
    }

    private function fixTable($table)
    {
        $rows = DB::table($table)->select('id', 'name', 'description')->get();
        $count = 0;
        foreach ($rows as $row) {
            $update = [];
            foreach (['name', 'description'] as $field) {
                $value = $row->$field;
                if (is_string($value) && strpos($value, '{') === 0 && strpos($value, '"it"') !== false) {
                    $decoded = json_decode($value, true);
                    if (is_array($decoded) && isset($decoded['it'])) {
                        $update[$field] = $decoded['it'];
                    }
                }
            }
            if (!empty($update)) {
                DB::table($table)->where('id', $row->id)->update($update);
                $this->info("Aggiornato $table id={$row->id}: " . json_encode($update));
                $count++;
            }
        }
        $this->info("Tabella $table: $count record aggiornati.");
    }
}
