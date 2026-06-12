<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;

class SettingController extends Controller
{
    /**
     * Display a listing of public settings.
     */
    public function index()
    {
        return response()->json([
            'site_name' => SettingsService::get('site_name', 'Debesties CMS'),
            'site_description' => SettingsService::get('site_description', 'A Laravel CMS'),
        ]);
    }
}
