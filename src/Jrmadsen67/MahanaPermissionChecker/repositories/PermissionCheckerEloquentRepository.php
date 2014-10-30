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

	protected $group_actions_start_time_field;

	protected $group_actions_end_time_field;

	protected $group_actions_timed;


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

	function check_permissions($action, array $group_ids, $object)
	{
		// user has no groups
		if (empty($group_ids)) return false;

		$lineage = array_map('trim', explode('-', isset($object['lineage'])? $object['lineage']: ''));

		// object not registered, or lineage improperly set up
		if (empty($lineage)) return false;		

		$count_row = GroupActions::select(\DB::Raw('COUNT(*) as `count`'), \DB::Raw('SUM(' . $this->group_actions_deny_field . ') AS `deny`'))
			->where(function($query) use ($action, $lineage, $group_ids)
			{
				$query->whereIn($this->group_actions_action_code_field, array($action, 'DENY'));
				$query->whereIn($this->group_actions_object_registry_id_field, $lineage);
				$query->whereIn($this->group_actions_group_id_field, $group_ids);

				if ($this->group_actions_timed) {
				    $now = \Carbon\Carbon::now()->toDateTimeString();

					$query->where(function($query) use ($now){
						$query->where($this->group_actions_start_time_field, '<=', $now);
						$query->orWhereNull($this->group_actions_start_time_field);
					});
					$query->where(function($query) use ($now){
						$query->where($this->group_actions_end_time_field, '>=', $now);
						$query->orWhereNull($this->group_actions_end_time_field);
					});
				}
			})
			->first();	

		return (!empty($count_row) && $count_row->count && !$count_row->deny);
	}

	function check_child_permissions($action, array $group_ids, $object)
	{
		// user has no groups
		if (empty($group_ids)) return false;

		$children = GroupActions::where(function($query) use ($action, $group_ids, $object)
			{
				$query->where($this->group_actions_object_registry_parent_id_field, '=', $object['id']);
				$query->whereIn($this->group_actions_action_code_field, array($action));
				$query->whereIn($this->group_actions_group_id_field, $group_ids);

				if ($this->group_actions_timed) {
				    $now = \Carbon\Carbon::now()->toDateTimeString();

					$query->where(function($query) use ($now){
						$query->where($this->group_actions_start_time_field, '<=', $now);
						$query->orWhereNull($this->group_actions_start_time_field);
					});
					$query->where(function($query) use ($now){
						$query->where($this->group_actions_end_time_field, '>=', $now);
						$query->orWhereNull($this->group_actions_end_time_field);
					});
				}
			
			})->get();

		if ($children->isEmpty())	return false;

		foreach ($children as $key => $child) {
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