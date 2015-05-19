<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveFundedFromFundingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('funding', function(Blueprint $table)
		{
			$table->dropColumn('funded');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('funding', function(Blueprint $table)
		{
			$table->double('funded')->default(0);
		});
	}

}
