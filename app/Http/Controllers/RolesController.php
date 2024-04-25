<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RolesController extends Controller
{
    public function index(){
        $roles = Role::all();
        $output['roles'] = $roles;
        return view('roles.list', $output);
    }

    public function create(){
        return view('roles.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        Role::create([
            'name' => $request->name,
            'status'    => $request->status
        ]);
        return Redirect::route('roles')->with('success', 'New role successfully created!');
    }

    public function edit($id){
        $role = Role::find($id);
        $permissions = $role->permissions;
        if(!$role){
            return back()->with('error', 'Role not found with this name');
        }

        $allPermissions = Permission::all();
        $modifiedPermissions = $allPermissions->map(function ($permission) {
            $nameParts = explode(' ', $permission->name);
            array_pop($nameParts);
            return implode(' ', $nameParts);
        })->unique();
        $output['allPermissions'] = $modifiedPermissions;
        $output['rolePermissions'] = $permissions;
        $output['role'] = $role;
        $output['edit'] = true;
        return view('roles.create', $output);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        Role::find($id)->update([
            'name' => $request->name,
            'status'    => $request->status
        ]);
        return Redirect::route('roles')->with('success', 'New role successfully updated!');
    }

    public function updateRolePermissions(Request $request, $roleId)
    {
        $role = Role::find($roleId);
        $requestData = $request->all();
        foreach ($requestData as $key => $value) {
            $cleanedKey = str_replace('_', ' ', $key);
            $cleanedValue = str_replace('_', ' ', $value);
            unset($requestData[$key]);
            $requestData[$cleanedKey] = $cleanedValue;
        }
        $existingPermissions = $role->permissions;
        if($existingPermissions){
            $role->revokePermissionTo($existingPermissions);
        }
        foreach ($requestData as $key => $value) {
            if ($value === 'on') {
                $permission_name = $key;
                $role->givePermissionTo($permission_name);
            }
        }
        return redirect()->back()->with('success', 'Permissions updated successfully');
    }
}
