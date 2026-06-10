<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomepageBuilderController extends Controller
{
    public function index()
    {
        return view('admin.homepage-builder.index');
    }
}
