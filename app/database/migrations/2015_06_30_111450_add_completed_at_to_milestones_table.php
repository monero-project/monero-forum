<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCompletedAtToMilestonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('milestones', function(Blueprint $table)
		{
			$table->date('completed_at');
			$table->double('funds')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('milestones', function(Blueprint $table)
		{
			$table->dropColumn('completed_at');
			$table->dropColumn('funds');
		});
	}

}
