<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostsIndexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('posts', function($table)
		{
    		$table->index('thread_id');
			$table->index('weight');
			$table->index('is_queued');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('posts', function($table)
		{
			$table->dropIndex('thread_id');
			$table->dropIndex('weight');
			$table->dropIndex('is_queued');
		});
	}

}
