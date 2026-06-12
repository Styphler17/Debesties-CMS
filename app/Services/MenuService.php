<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class MenuService
{
    public static function getMenu(string $location): ?Menu
    {
        return Cache::remember("menu:location:{$location}", 3600, function () use ($location) {
            return Menu::with(['items' => function ($query) {
                $query->whereNull('parent_id')->with('children');
            }])->where('location', $location)->first();
        });
    }
}
