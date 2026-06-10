<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function show(string $slug)
    {
        return view('public.author', compact('slug'));
    }
}
