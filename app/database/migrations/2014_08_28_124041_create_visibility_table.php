<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVisibilityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('visibility', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps('');
			$table->integer('role_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('content_type');
			$table->integer('content_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('visibility');
	}

}
