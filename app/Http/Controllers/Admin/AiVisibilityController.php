<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AiVisibilityController extends Controller
{
    public function index()
    {
        return view('admin.ai-visibility.index');
    }
}
