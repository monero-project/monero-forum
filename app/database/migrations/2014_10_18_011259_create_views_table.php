<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateViewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('views', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('thread_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('views');
	}

}
