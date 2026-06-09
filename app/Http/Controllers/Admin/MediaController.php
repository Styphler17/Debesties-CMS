<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        return view('admin.media.index');
    }

    public function store(Request $request)
    {
        // Store media logic
    }

    public function show(string $id)
    {
        return view('admin.media.show', compact('id'));
    }

    public function destroy(string $id)
    {
        // Destroy media logic
    }
}
