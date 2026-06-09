<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Seed default system settings
        Setting::create(['key' => 'site_name', 'value' => 'Debesties CMS', 'type' => 'text', 'group' => 'general']);
        Setting::create(['key' => 'site_description', 'value' => 'Premium CMS Platform', 'type' => 'textarea', 'group' => 'general']);
    }
}
