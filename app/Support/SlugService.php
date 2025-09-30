<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugService
{
    public static function unique(Model $model, string $source, ?int $ignoreId = null, string $column = 'slug'): string
    {
        $base = Str::slug($source);
        $slug = $base;
        $i = 2;

        while ($model->newQuery()
            ->where($column, $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
