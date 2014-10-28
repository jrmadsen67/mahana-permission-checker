<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(\Config::get('mahana-permission-checker::permission_checker.object_types_table'), function(Blueprint $table)
		{
			$table->increments(\Config::get('mahana-permission-checker::permission_checker.object_types_id_field'));
			$table->string(\Config::get('mahana-permission-checker::permission_checker.object_types_type_field'), 55);
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
		Schema::drop(\Config::get('mahana-permission-checker::permission_checker.object_types_table'));
	}

}
