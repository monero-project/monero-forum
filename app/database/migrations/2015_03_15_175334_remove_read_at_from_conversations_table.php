<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveReadAtFromConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conversations', function(Blueprint $table)
		{
			$table->dropColumn('read_at');
			$table->dateTime('user_read_at');
			$table->dateTime('receiver_read_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conversations', function(Blueprint $table)
		{
			$table->dropColumn('user_read_at');
			$table->dropColumn('receiver_read_at');
			$table->dateTime('read_at');
		});
	}

}
