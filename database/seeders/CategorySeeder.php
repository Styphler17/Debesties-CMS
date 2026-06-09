<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Seed default categories
        Category::create(['name' => 'General', 'slug' => 'general']);
        Category::create(['name' => 'News', 'slug' => 'news']);
    }
}
