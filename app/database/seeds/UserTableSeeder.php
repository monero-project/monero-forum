<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();
		
		$faker = Faker::create();

		for ($i = 0; $i < 300; $i++)
		{
				 $user = User::create(array(
				    'username' => $faker->userName,
				    'email' => $faker->email,
				    'password' => Hash::make($faker->word)
				  ));
		}
	}

}