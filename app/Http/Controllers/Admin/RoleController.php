<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index');
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        // Store role logic
    }

    public function show(string $id)
    {
        return view('admin.roles.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.roles.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        // Update role logic
    }

    public function destroy(string $id)
    {
        // Destroy role logic
    }
}
