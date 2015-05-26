<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('post_id')->unsigned();
			$table->tinyInteger('vote');
		});
		
		Schema::table('posts', function(Blueprint $table)
		{
			$table->softDeletes();	
			$table->dropColumn('title');
		});
		
		Schema::table('threads', function(Blueprint $table)
		{
			$table->softDeletes();	
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('votes');
	}

}
