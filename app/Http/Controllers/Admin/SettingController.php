<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Setting::class);

        return view('admin.settings.index');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Setting::class);

        $settings = $request->except('_token');
        foreach ($settings as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            SettingsService::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
