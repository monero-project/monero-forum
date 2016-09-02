<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreadViewsIndexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('thread_views', function($table)
		{
    		$table->index('user_id');
			$table->index('thread_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('thread_views', function($table)
		{
    		$table->dropIndex('user_id');
			$table->dropIndex('thread_id');
		});
	}

}
