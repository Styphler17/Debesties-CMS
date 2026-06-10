<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Seed default categories
        Category::create(['name' => 'General', 'slug' => 'general']);
        Category::create(['name' => 'News', 'slug' => 'news']);
    }
}
