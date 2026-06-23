<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::withCount('roles')->orderBy('group')->orderBy('name')->get();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $groups = Permission::distinct()->pluck('group')->sort()->values();
        return view('admin.permissions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:permissions,slug',
            'group'       => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        Permission::create($request->only('name', 'slug', 'group', 'description'));

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $groups     = Permission::distinct()->pluck('group')->sort()->values();
        return view('admin.permissions.edit', compact('permission', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:permissions,slug,' . $permission->id,
            'group'       => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        $permission->update($request->only('name', 'slug', 'group', 'description'));

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->roles()->detach();
        $permission->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
