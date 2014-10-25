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
		Schema::create('group_actions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('object_registry_id')->nullable();
			$table->integer('object_registry_parent_id')->nullable();
			$table->integer('group_id');
			$table->string('action_code', 55);
			$table->tinyInteger('deny')->default(0);
			$table->integer('object_id');
			$table->integer('object_type_id');
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
		Schema::drop('group_actions');
	}

}
