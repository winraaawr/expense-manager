<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolesRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();

        return Inertia::render('Roles', [
            "roles" => $roles
        ]);
    }

    public function show(Request $request){
        return Role::find($request->user()->id);
    }

    public function store(StoreRolesRequest $request)
    {
        Role::create($request->validated());

        return redirect()->route(route: 'roles')->with('message', 'New role created successfully.');
    }

    public function update(Role $role, UpdateRoleRequest $request)
    {
        $role->update($request->validated());
        return redirect()->route(route: 'roles')->with('message', 'A role was updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route(route: 'roles')->with('message', 'A role was deleted successfully.');
    }

    
}
