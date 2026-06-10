<?php

namespace App\Actions\SEO;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateSlug
{
    public function handle(string $title, string $table): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (DB::table($table)->where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
