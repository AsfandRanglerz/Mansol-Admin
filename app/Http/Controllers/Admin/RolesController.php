<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Role;
use App\Models\sideMenu;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::with('rolePermission')->orderBy('status', 'desc')->get();
        // return $roles;
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = sideMenu::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        // Validate Request
        $validated = $request->validate([
            'title' => 'required|string|unique:roles,title',
            'status' => 'required|boolean',
            'permissions' => 'required|array',
            'permissions.*' => 'required',
            'sub_permissions' => 'required|array',
            'sub_permissions.*' => 'required',
        ]);
        // dd($request);
        
        // Create the Role
        $role = Role::create([
            'title' => $validated['title'],
            'status' => $validated['status'],
        ]);

        // Save Permissions with Sub-Permissions
        foreach ($validated['permissions'] as $permissionId) {
            $subPermissions = $validated['sub_permissions'][$permissionId] ?? [];

            // Save each sub-permission as a separate row
            foreach ($subPermissions as $subPermission) {
                RolePermission::create([
                    'role_id' => $role->id,      // Use the created role's ID
                    'sideMenu_id' => $permissionId,
                    'name' => $subPermission,   // Save each sub-permission separately
                ]);
            }
        }

        // Return success message or redirect
        return redirect()->route('roles.index')->with(['message' => 'Role and Permissions Saved Successfully']);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id); // Assuming `Role` model is correct

        $permissions = sideMenu::all(); // Assuming sideMenu holds permission data

        $assignedPermissions = RolePermission::where('role_id', $id)
            ->with('sideMenu') // Load related sideMenu model
            ->get()
            ->map(function ($rolePermission) {
                return [
                    'id' => $rolePermission->sideMenu_id,
                    'name' => $rolePermission->sideMenu->name,
                    'permissions' => $rolePermission->sideMenu_id, // Assuming permissions attribute has create, edit, view, delete, etc.
                    'subPermissionName' => $rolePermission->name
                ];
            })
            ->toArray();

        // return $assignedPermissions;

        return view('admin.roles.edit', compact('role', 'permissions', 'assignedPermissions'));
    }

    // public function update(Request $request, $id)
    // {
    //     return $request;
    // }

    public function update(Request $request, $id)
    {
        // Validate Request
        $request->validate([
            'status' => 'required|boolean',
            'permissions' => 'required|array',
            'permissions.*' => 'required',
            'sub_permissions' => 'required|array',
            'sub_permissions.*' => 'required',
        ]);
    
        // Find the Role
        $role = Role::findOrFail($id);
    
        // Update Role Details
        $role->update([
            'status' => $request->status,
        ]);
    
        // Clear Existing Permissions
        RolePermission::where('role_id', $role->id)->delete();
    
        // Save Permissions with Sub-Permissions
        foreach ($request->permissions as $permissionId) {
            $subPermissions = $request->sub_permissions[$permissionId] ?? [];
    
            // Save each sub-permission as a separate row
            foreach ($subPermissions as $subPermission) {
                RolePermission::create([
                    'role_id' => $role->id,      // Use the role's ID
                    'sideMenu_id' => $permissionId,
                    'name' => $subPermission,   // Save each sub-permission separately
                ]);
            }
        }
    
        // Return success message or redirect
        return redirect()->route('roles.index')->with(['message' => 'Role Updated Successfully']);
    }

    public function destroy($id)
    {
        // return $id;
        Role::destroy($id);
        return redirect()->route('roles.index')->with(['message' => 'Role Deleted Successfully']);

    }
    
    

}
