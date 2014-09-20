<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLockToForumsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forums', function(Blueprint $table)
		{
			$table->integer('lock');
		});
		Schema::table('threads', function(Blueprint $table)
		{
			$table->integer('lock');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('forums', function(Blueprint $table)
		{
			$table->dropColumn('lock');
		});
		Schema::table('threads', function(Blueprint $table)
		{
			$table->dropColumn('lock');
		});
	}

}
