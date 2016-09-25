<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForumIndexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forums', function ($table)
		{
			$table->index('category_id');
			$table->index('parent_id');
			$table->index('position');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('forums', function ($table)
		{
			$table->dropIndex('category_id');
			$table->dropIndex('parent_id');
			$table->dropIndex('position');
		});
	}

}
