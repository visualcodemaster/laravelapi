<?php


namespace App\Services\Role;


use App\Models\Role;
use App\Services\BaseService;

class RoleService extends BaseService {

	public function __construct( Role $role ) {
		$this->model = $role;
	}

    public function show( $id ) {
        $data = Role::findOrFail($id);
        return $data;
    }

}
