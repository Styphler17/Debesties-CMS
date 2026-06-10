<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function show(string $slug)
    {
        return view('public.article', compact('slug'));
    }
}
