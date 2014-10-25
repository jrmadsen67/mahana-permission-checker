<?php
namespace Jrmadsen67\MahanaPermissionChecker\models;

class ObjectTypes extends \Eloquent {

	protected $table; 
	
	protected $fillable;

	public function __construct()
	{

		$this->setFillable();

		$this->setTable(\Config::get('mahana-permission-checker::permission_checker.object_types_table'));
	}

	// Eloquent\Model uses a new static($attributes) that doesn't play nicely with __construct()
	public static function create(array $attributes)
	{
		$model = new ObjectTypes;
		$model->fill($attributes);
		$model->save();
		return $model;
	}

	public function setFillable()
	{
		$id      = \Config::get('mahana-permission-checker::permission_checker.object_types_id_field');
		$type = \Config::get('mahana-permission-checker::permission_checker.object_types_type_field');


		$this->fillable = [$id, $type];
	}

}