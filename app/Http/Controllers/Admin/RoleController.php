<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SEO\GenerateSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::withCount('users')->with('permissions')->get();
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $slug = (new GenerateSlug)->handle($request->name, 'roles');

        $role = Role::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'role' => $role]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function update(UpdateRoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('update', $role);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'role' => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'description' => $role->description,
                    'permissions_matrix' => $role->permissions->pluck('id'),
                ],
            ]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('delete', $role);

        if (in_array($role->slug, ['super_admin', 'subscriber'])) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'System roles cannot be deleted.'], 422);
            }

            return redirect()->route('admin.roles.index')->with('error', 'System roles cannot be deleted.');
        }

        if ($role->users()->exists()) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete role: It is currently assigned to users.'], 422);
            }

            return redirect()->route('admin.roles.index')->with('error', 'Cannot delete role: It is currently assigned to users.');
        }

        $role->permissions()->detach();
        $role->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Role deleted successfully.']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
