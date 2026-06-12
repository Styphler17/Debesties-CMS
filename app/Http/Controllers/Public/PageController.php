<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(Page $page)
    {
        if ($page->status !== 'published') {
            abort(404);
        }

        return view('public.page', compact('page'));
    }
}
