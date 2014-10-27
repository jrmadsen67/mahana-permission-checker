<?php namespace Jrmadsen67\MahanaPermissionChecker\repositories;

use Jrmadsen67\MahanaPermissionChecker\models\ObjectTypes;
use Jrmadsen67\MahanaPermissionChecker\models\GroupActions;
use Config;
 

class PermissionCheckerEloquentRepository implements PermissionCheckerRepositoryInterface
{


	protected $object_registry_table;

	protected $object_registry_object_id_field;

	protected $object_registry_object_type_id_field;

	protected $object_types_table;

	protected $object_types_id_field;

	protected $object_types_type_field;

	protected $group_actions_table;

	protected $group_actions_deny_field;

	protected $group_actions_action_code_field;

	protected $group_actions_group_id_field;

	protected $group_actions_object_registry_id_field;

	protected $group_actions_object_registry_parent_id_field;


    public function __construct()
    {
        $this->initialize(Config::get('mahana-permission-checker::permission_checker'));
    }


    public function initialize($config){

        if(!is_array($config)) return false;
        
        foreach($config as $key => $val){
            $this->$key = $val;
        }
    }

    function has_permission($action, $user, $object)
    {

    }

	function check_permissions($action, $user, $object)
	{
		// user has no groups
		if (empty($user['group_ids'])) return false;

		$lineage = array_map('trim', explode('-', $object['lineage'])); 
		// object not registered, or lineage improperly set up
		if (empty($lineage)) return false;		

		$count_row = $this->db->select('COUNT(*) as `count`, SUM(' . $this->group_actions_deny_field . ') AS `deny`', false)
			->where_in($this->group_actions_action_code_field, array($action, 'DENY'))
			->from($this->group_actions_table)
			->where_in($this->group_actions_object_registry_id_field, $lineage)
			->where_in($this->group_actions_group_id_field, $user['group_ids'])
			->get()
			->row();

		return (!empty($count_row) && $count_row->count && !$count_row->deny);
	}

	function check_child_permissions($action, $user, $object)
	{
		// user has no groups
		if (empty($user['group_ids'])) return false;

		$children = $this->db
			->from($this->group_actions_table)
			->where($this->group_actions_object_registry_parent_id_field . ' = ', $object['parent_id'])
			->where_in($this->group_actions_action_code_field, array($action))
			->where_in($this->group_actions_group_id_field, $user['group_ids'])
			->get();

		if (!$children->num_rows())	return false;

		foreach ($children->result() as $key => $child) {
			$object_type_id = $child->object_type_id;
			$objects_ids[]	= $child->object_id;
		}

		return array('object_type_id'=>$object_type_id, 'objects_ids'=>$objects_ids );
	}	

	function get_object_registry_id($object_id, $object_type_id)
	{
		$query = \DB::table($this->object_registry_table)->where($this->object_registry_object_id_field , '=', $object_id)
			->where($this->object_registry_object_type_id_field , '=', $object_type_id)
			->first();	

		return (empty($query)) ? 0 : $query->id ;			
	}

	function get_object($object_id, $object_type_id)
	{
		// load our object types
		$object_types_array = $this->get_object_types();
		if (empty($object_types_array) || !isset($object_types_array[$object_type_id])) return false;

		// get the object record dynamically
		$results = \DB::table($object_types_array[$object_type_id])->where($this->object_types_id_field , '=', $object_id)->first();

		if (empty($results)) return false;
		$object = (array)$results;

		// get the object_registry record - 
		// we could use a join, but expecting this table to get very big
		$query = \DB::table($this->object_registry_table)->where($this->object_registry_object_id_field , '=', $object_id)
			->where($this->object_registry_object_type_id_field , '=', $object_type_id)
			->first();

		if (empty($query)) return  $object;	
		$query = (array)$query;

		// we'd like a complete object that includes registry info
		$object = array_merge($object, $query);	

		return $object;
	}

	function get_object_types()
	{
		// if you are certain of your object_types list, you may simply create an array in the config 
		// file & return it from this function, instead of the additional db call

		$object_types = \Config::get('mahana-permission-checker::permission_checker.object_types_array');
		if (!empty($object_types)) { return $object_types; }

		$results = ObjectTypes::get();
		if ($results->isEmpty()) return [];

		foreach ($results as $row) {
			$object_types[$row->{$this->object_types_id_field}] = $row->{$this->object_types_type_field};
		}

		return $object_types;
	}


	function create_group_action($data)
	{
		$insert = GroupActions::create($data);
		return $insert->id;

	}



}	