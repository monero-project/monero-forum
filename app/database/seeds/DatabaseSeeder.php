<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
		$this->call('CategoryTableSeeder');
		$this->call('ForumTableSeeder');
		$this->call('ThreadTableSeeder');
		$this->call('PostTableSeeder');
		$this->call('TrustTableSeeder');
	}

}
