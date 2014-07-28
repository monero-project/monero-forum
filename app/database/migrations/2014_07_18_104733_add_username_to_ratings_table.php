<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUsernameToRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ratings', function(Blueprint $table)
		{
			$table->dropColumn('user_id');
			$table->dropColumn('rated_id');
			$table->string('username');
			$table->string('rated_username');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ratings', function(Blueprint $table)
		{
			$table->dropColumn('username');
			$table->dropColumn('rated_username');
			$table->string('user_id');
			$table->string('rated_id');
		});
	}

}
