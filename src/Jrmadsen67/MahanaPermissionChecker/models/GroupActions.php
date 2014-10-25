<?php
namespace Jrmadsen67\MahanaPermissionChecker\models;

class GroupActions extends \Eloquent {

	protected $table; 
	
	protected $fillable;

	public function __construct()
	{

		$this->setFillable();

		$this->setTable(\Config::get('mahana-permission-checker::permission_checker.group_actions_table'));
	}

	// Eloquent\Model uses a new static($attributes) that doesn't play nicely with __construct()
	public static function create(array $attributes)
	{
		$model = new GroupActions;
		$model->fill($attributes);
		$model->save();
		return $model;
	}

	public function setFillable()
	{
		$fillable['id']                        = \Config::get('mahana-permission-checker::permission_checker.group_actions_id_field');
		$fillable['object_registry_id']        = \Config::get('mahana-permission-checker::permission_checker.group_actions_object_registry_id_field');
		$fillable['object_registry_parent_id'] = \Config::get('mahana-permission-checker::permission_checker.group_actions_object_registry_parent_id_field');
		$fillable['group_id']                  = \Config::get('mahana-permission-checker::permission_checker.group_actions_group_id_field');
		$fillable['action_code']               = \Config::get('mahana-permission-checker::permission_checker.group_actions_action_code_field');
		$fillable['deny']                      = \Config::get('mahana-permission-checker::permission_checker.group_actions_deny_field');
		$fillable['object_id']                 = \Config::get('mahana-permission-checker::permission_checker.group_actions_object_id_field');
		$fillable['object_type_id']            = \Config::get('mahana-permission-checker::permission_checker.group_actions_object_type_id_field');

		$this->fillable = $fillable;
	}

}