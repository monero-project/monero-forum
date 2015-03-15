<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveSenderIdFromMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('messages', function(Blueprint $table)
		{
			$table->dropColumn('sender_id');
			$table->dropColumn('receiver_id');
			$table->integer('user_id')->unsigned();
			$table->integer('conversation_id')->unsigned();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('messages', function(Blueprint $table)
		{
			$table->integer('sender_id')->unsigned();
			$table->integer('receiver_id')->unsigned();
			$table->dropColumn('user_id');
			$table->dropColumn('conversation_id');
		});
	}

}
