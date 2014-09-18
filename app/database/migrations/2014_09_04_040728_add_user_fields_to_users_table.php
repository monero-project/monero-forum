<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUserFieldsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('profile_picture')->default('no_picture.jpg');
			$table->boolean('email_public');
			$table->string('website')->nullable();
			$table->string('monero_address')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('profile_picture');
			$table->dropColumn('email_public');
			$table->dropColumn('website');
			$table->dropColumn('monero_address');
		});
	}

}
