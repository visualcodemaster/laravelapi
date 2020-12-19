<?php


namespace App\Services\User;

use App\Models\Role;
use App\Models\User;
use App\Services\BaseService;

class UserService extends BaseService {

	public function __construct(User $user)
	{
		$this->model = $user;
	}

	/**
	 * Does the user has super admin role ?
	 * @return bool
	 */
	public function isSuperAdmin(  ) {

		// if the user has a role of super_admin from all the roles
		foreach ($this->model->roles as $role){
			if($role->slug == 'super_admin'){
				return true;
			}
		}
		return false;
	}

	public function assignRole(Role $role ) {
		// is the role already has?

		// if not add it

		return $this->model->roles()->save($role);
	}

	public function hasRole( $role_name ) {
		// if the user has a role of super_admin from all the roles
		foreach ($this->model->roles as $role){
			if($role->slug == $role_name){
				return true;
			}
		}
		return false;
	}

	public function create( $request ) {
		$data = [
			'email' => $request['email'],
			'password' => bcrypt($request['password']),
			'first_name' => $request['first_name'],
			'last_name' => $request['last_name'],
		];

		if(isset($request->region_id)) $data['region_id'] = $request->region_id;

		return $this->model->create($data);
	}
}
