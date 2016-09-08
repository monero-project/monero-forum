<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreadIndexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('threads', function($table)
		{
    		$table->index('forum_id');
			$table->index('user_id');
			$table->index('post_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('threads', function($table)
		{
    		$table->dropIndex('forum_id');
			$table->dropIndex('user_id');
			$table->dropIndex('post_id');
		});
	}

}
