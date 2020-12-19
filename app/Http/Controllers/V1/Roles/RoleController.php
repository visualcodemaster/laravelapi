<?php

namespace App\Http\Controllers\V1\Roles;

use App\Http\Requests\Roles\StoreRolesRequest;
use App\Http\Requests\Roles\UpdateRolesRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $roles = [];
        if ($request->ajax())
        {
            $roles = Role::query();

            return DataTables::of($roles)->only(['id','name'])->toJson();
        }

        return view('backend.content.user_management.roles.index',['roles'=>$roles]);
    }

    public function rolesAttachedUsers(Request $request,Role $role)
    {
        $users = $role->users()->get();
        return DataTables::of($users)->only(['id','name','email'])->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.content.user_management.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolesRequest $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->slug = strtolower(str_replace(' ','-',trim($request->name)));
        $role->guard_name = 'web';
        $role->permissions = json_encode([]);
        $role->save();
        return  redirect()->route('roles.index')->with('success','Role Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        if(request()->ajax()==true)
        {

        }
        return view('backend.content.user_management.roles.show',['role'=>$role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('backend.content.user_management.roles.edit',['role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        return  redirect()->route('roles.index')->with('success','Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return  redirect()->route('roles.index')->with('success','Role Deleted Successfully');
    }

    public function attachRoleToUserCreate(Request $request,User $user)
    {
        $roles = Role::select('id','name')->get();
        return view('backend.content.user_management.roles.attach',compact('user','roles'));
    }

    public function attachRoleToUserStore(Request $request,User $user)
    {
        $user->roles()->sync($request->role);
        return  redirect()->route('users.index')->with('success','Role Attached Successfully');
    }

}
