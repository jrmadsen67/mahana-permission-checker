<?php namespace Jrmadsen67\MahanaPermissionChecker;

use Jrmadsen67\MahanaPermissionChecker\repositories\PermissionCheckerRepositoryInterface;


class MahanaPermissionChecker {

	protected $permission_repo;

	public function __construct(PermissionCheckerRepositoryInterface $permission_repo)
	{
		$this->permission_repo = $permission_repo;
	}


	public function has_permission($action, $user, $object){
		return $this->permission_repo->has_permission($action, $user, $object);
	}
	
	public function check_permissions($action, $group_ids, $object){
		return $this->permission_repo->check_permissions($action, $group_ids, $object);
	}
	
	public function check_child_permissions($action, $group_ids, $object){
		return $this->permission_repo->check_child_permissions($action, $group_ids, $object);
	}
	
	public function get_object_registry_id($object_id, $object_type_id){
		return $this->permission_repo->get_object_registry_id($object_id, $object_type_id);
	}
	
	public function get_object($object_id, $object_type_id){
		return $this->permission_repo->get_object($object_id, $object_type_id);
	}
	
	public function get_object_types(){
		return $this->permission_repo->get_object_types();
	}
	
	public function create_group_action($data){
		return $this->permission_repo->create_group_action($data);
	}


}	