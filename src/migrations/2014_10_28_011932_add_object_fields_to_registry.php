<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObjectFieldsToRegistry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(\Config::get('mahana-permission-checker::permission_checker.object_registry_table'), function(Blueprint $table)
		{
			$table->integer(\Config::get('mahana-permission-checker::permission_checker.object_registry_object_id_field'));
			$table->integer(\Config::get('mahana-permission-checker::permission_checker.object_registry_object_type_id_field'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table(\Config::get('mahana-permission-checker::permission_checker.object_registry_table'), function($table)
		{
		    $table->dropColumn(\Config::get('mahana-permission-checker::permission_checker.object_registry_object_id_field'));
		    $table->dropColumn(\Config::get('mahana-permission-checker::permission_checker.object_registry_object_type_id_field'));
		});
	}

}
