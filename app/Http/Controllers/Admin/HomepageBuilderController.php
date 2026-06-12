<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class HomepageBuilderController extends Controller
{
    public function index()
    {
        $layout = SettingsService::get('homepage_layout', '[]');
        return view('admin.homepage-builder.index', compact('layout'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layout' => ['required', 'string'],
        ]);

        SettingsService::set('homepage_layout', $request->input('layout'));

        return response()->json([
            'success' => true,
            'message' => 'Homepage layout configuration saved successfully ✓',
        ]);
    }
}
