<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateXmrPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('xmr_payments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->enum('type', ['receive', 'transfer']);
			$table->char('address', 95)->default(NULL);
			$table->string('payment_id', 64);
			$table->bigInteger('amount');
			$table->timestamp('expires_at')->default('0000-00-00 00:00:00');
			$table->enum('status', ['pending', 'complete']);
			$table->bigInteger('block_height');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('xmr_payments');
	}

}
