<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{    
    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        // get roles
        $roles = Role::when(request()->q, function($roles) {
            $roles = $roles->where('name', 'like', '%' . request()->q . '%');
        })->with('permissions')->latest()->paginate(5);

        // render with inertia
        return inertia('Apps/Roles/Index', [
            'roles' => $roles,
        ]);
    }
    
    /**
     * Method create
     *
     * @return void
     */
    public function create()
    {
        // get permission all
        $permissions = Permission::all();

        // render with inertia
        return inertia('Apps/Roles/Create', [
            'permissions' => $permissions,
        ]);
    }
    
    /**
     * Method store
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required',
            'permissions'   => 'required',
        ]);

        // create role
        $role = Role::create(['name' => $request->name]);

        // assign permissions to role
        $role ->givePermissionTo($request->permissions);

        // redirect
        return redirect()->route('apps.roles.index');
    }
    
    /**
     * Method edit
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function edit($id)
    {
        // get role
        $role = Role::with('permissions')->findOrFail($id);

        // get permission all
        $permissions = Permission::all();

        // render with inertia
        return inertia('Apps/Roles/Edit', [
            'role'                  => $role,
            'permissions'     => $permissions,
        ]);
    }
    
    /**
     * Method update
     *
     * @param Request $request [explicite description]
     * @param Role $role [explicite description]
     *
     * @return void
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name'             => 'required',
            'permissions'   => 'required',
        ]);

        // update role
        $role->update(['name' => $request->name]);

        // sync permissions
        $role->syncPermissions($request->permissions);

        // redirect
        return redirect()->route('apps.roles.index');
    }
    
    /**
     * Method destroy
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function destroy($id)
    {
        // find role by ID
        $role = Role::findOrFail($id);

        // delete role
        $role->delete();

        // redirect
        return redirect()->route('apps.roles.index');
    }
}
