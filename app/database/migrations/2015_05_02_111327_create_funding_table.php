<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFundingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('funding', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('thread_id')->unsigned();
			$table->string('currency'); //currency code.
			$table->double('target')->unsigned();
			$table->double('funded')->unsigned()->default(0);
			$table->string('payment_id');
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
		Schema::drop('funding');
	}

}
