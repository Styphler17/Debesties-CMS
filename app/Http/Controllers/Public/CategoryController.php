<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        return view('public.category', compact('slug'));
    }
}
