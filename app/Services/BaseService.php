<?php


namespace App\Services;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class BaseService {

	use AuthorizesRequests;

	protected $model;
	protected $relations = [];

	public function create($data){
		return $this->model->create($data);
	}

	public function update($data, $id) {
		return $this->model
			->where('id', $id)
			->update($data);
	}
	public function find($id){
		return $this->model
			->with($this->relations)
			->findOrFail($id);
	}

	public function all(  ) {
		return $this->model
			->with($this->relations)
			->all();
	}

	public function paginate( ){
		return $this->model
			->with($this->relations)
			->paginate();
	}

	public function with( array $relations ) {
		$this->relations = $relations;
	}

	public function hasAuthorize( $ability, $arguments) {
		// policy of the model
		$this->authorize($ability, $arguments);
	}

	public function getModelName(  ) {
		return $this->model;
	}

	public function select(  ) {
		return $this->model
			->select();
	}

	public function whereIn( $column, $array ) {
		return $this->model
			->whereIn($column, $array);
	}

	public function where( $column, $value ) {
		return $this->model
			->where($column, $value);
	}

	public function get(  ) {
		return $this->model
			->with($this->relations)
			->get();
	}

	public function exists( $data ) {
		$exist = $this->model;
		foreach ($data as $key => $value){
			$exist = $exist->where($key, $value);
		}
		$exists = $exist->first();

		return $exists;
	}
}
