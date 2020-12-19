<?php

namespace App\Http\Controllers\V1\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class RolePermissionsController extends Controller
{
    public function rolePermissions(Role $role)
    {
        $routes = Route::getRoutes();

        $actions = [];
        foreach ($routes as $route) {
//            if ($route->getName() != "" && !substr_count($route->getName(), 'payment')) {
            if ($route->getName() != "") {
                $actions[] = $route->getName();
            }
        }

        //remove hide option
        $input = preg_quote("hide", '~');
        $var = preg_grep('~' . $input . '~', $actions);
        $actions = array_values(array_diff($actions, $var));

        $var = [];
        //$i = 0;
        foreach ($actions as $key => $action) {
            $input = preg_quote(explode('.', $action )[0].".", '~');
            $var[$key] = preg_grep('~^' . $input . '~', $actions);
            $actions = array_values(array_diff($actions, $var[$key]));
        }

        $actions = array_filter($var);
        $rolesPermissions = json_decode($role->permissions,true);

        return View('backend.content.user_management.roles.permissions', compact('role', 'actions','rolesPermissions'));
    }

    public function rolePermissionsStore(Request $request,Role $role)
    {
        $role->permissions = [];
        $permissions = array();
        foreach ($request->permissions as $permission=>$value) {
            //if (!array_key_exists($permissions,$value)){
                $permissions = array_merge($permissions,[$value=>true]);
            //}
        }
        $role->permissions = json_encode($permissions);
        $role->save();
        return redirect(route('roles.index'))->with('success','Permission Synced Successfully');
    }
}
