<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMorePostsIndexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('posts', function($table)
		{
    		$table->index('user_id');
			$table->index('parent_id');
			$table->index('parsed');
			$table->index('is_sticky');
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
			$table->dropIndex('user_id');
			$table->dropIndex('parent_id');
			$table->dropIndex('parsed');
			$table->dropIndex('is_sticky');
		});
	}

}
