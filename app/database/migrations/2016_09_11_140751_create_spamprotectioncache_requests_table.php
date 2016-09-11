<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpamprotectioncacheRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('spamprotection_requests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('key', 10)->index();
			$table->string('value', 15);
			$table->tinyInteger('blacklisted');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('spamprotection_requests');
	}

}
