<?php


return [
	
	// The table created via Mahana Hierarchy. Just be sure these 
	// match for making queries
	'object_registry_table'                => 'object_registry',
	
	'object_registry_object_id_field'      => 'object_id',
	
	'object_registry_object_type_id_field' => 'object_type_id',
	
	
	// Object_types (resources) table
	'object_types_table'                   => 'object_types',
	
	'object_types_id_field'                => 'id',
	
	'object_types_type_field'              => 'type',

	// If your objects are a set array, you can save a db call by loading here
	'object_types_array' => [],


	// Group actions table
	'group_actions_table'                           => 'group_actions',
	
	'group_actions_id_field'                        => 'id',
	
	'group_actions_object_registry_id_field'        => 'object_registry_id',
	
	'group_actions_object_registry_parent_id_field' => 'object_registry_parent_id',
	
	'group_actions_group_id_field'                  => 'group_id',
	
	'group_actions_action_code_field'               => 'action_code',
	
	'group_actions_deny_field'                      => 'deny',
	
	'group_actions_object_id_field'                 => 'object_id',
	
	'group_actions_object_type_id_field'            => 'object_type_id',
	
	'group_actions_start_time_field'                => 'start_time',
	
	'group_actions_end_time_field'                  => 'end_time',

	// to help speed up queries, "timed permissions" can optionally be turned on/off
	// if turned off, no start_time/end_time will be checked in queries
	'group_actions_timed'							=> false,	

];