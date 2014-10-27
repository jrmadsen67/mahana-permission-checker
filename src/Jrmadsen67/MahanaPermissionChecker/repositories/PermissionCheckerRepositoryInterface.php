<?php namespace Jrmadsen67\MahanaPermissionChecker\repositories;
/**
 * Interface for the hierarchy repo
 */
interface PermissionCheckerRepositoryInterface
{
	function has_permission($action, $user, $object);
	function check_permissions($action, $user, $object);
	function check_child_permissions($action, $user, $object);
	function get_object_registry_id($object_id, $object_type_id);
	function get_object($object_id, $object_type_id);
	function get_object_types();
	function create_group_action($data);

}