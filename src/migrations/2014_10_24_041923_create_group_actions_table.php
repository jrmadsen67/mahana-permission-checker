<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(\Config::get('mahana-permission-checker::permission_checker.group_actions_table'), function(Blueprint $table)
		{
			$table->increments(\Config::get('mahana-permission-checker::permission_checker.group_actions_id_field'));
			$table->integer(\Config::get('mahana-permission-checker::permission_checker.group_actions_object_registry_id_field'))->nullable();
			$table->integer(\Config::get('mahana-permission-checker::permission_checker.group_actions_object_registry_parent_id_field'))->nullable();
			$table->integer(\Config::get('mahana-permission-checker::permission_checker.group_actions_group_id_field'));
			$table->string(\Config::get('mahana-permission-checker::permission_checker.group_actions_action_code_field'), 55);
			$table->tinyInteger(\Config::get('mahana-permission-checker::permission_checker.group_actions_deny_field'))->default(0);
			$table->integer(\Config::get('mahana-permission-checker::permission_checker.group_actions_object_id_field'));
			$table->integer(\Config::get('mahana-permission-checker::permission_checker.group_actions_object_type_id_field'));
			$table->softDeletes();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(\Config::get('mahana-permission-checker::permission_checker.group_actions_table'));
	}

}
