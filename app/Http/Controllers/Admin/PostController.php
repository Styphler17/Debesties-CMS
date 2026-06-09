<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index');
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        // Store logic
    }

    public function show(string $id)
    {
        return view('admin.posts.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.posts.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // Update logic
    }

    public function destroy(string $id)
    {
        // Destroy logic
    }
}
