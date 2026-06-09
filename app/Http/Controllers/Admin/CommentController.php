<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        return view('admin.comments.index');
    }

    public function create()
    {
        return view('admin.comments.create');
    }

    public function store(Request $request)
    {
        // Store logic
    }

    public function show(string $id)
    {
        return view('admin.comments.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.comments.edit', compact('id'));
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
