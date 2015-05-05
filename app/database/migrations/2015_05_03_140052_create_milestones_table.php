<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMilestonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('milestones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('funding_id')->unsigned();
			$table->string('title');
			$table->text('description')->nullable();
			$table->boolean('complete')->default(0);
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
		Schema::drop('milestones');
	}

}
