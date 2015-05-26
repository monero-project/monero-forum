<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TrustTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

			for ($i = 0; $i < 600; $i++)
			{
			  $user = User::orderBy(DB::raw('RAND()'))->first();
			  $trusted_user = User::orderBy(DB::raw('RAND()'))->first();
			  $trust = Trust::create(array(
			    'user_id' => $user->id,
			    'trusted_user_id' => $trusted_user->id
			  ));
		}	
	}

}