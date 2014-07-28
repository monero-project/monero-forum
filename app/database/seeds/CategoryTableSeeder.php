<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CategoryTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		for ($i = 0; $i < 10; $i++)
		{
		  $category = Category::create(array(
		    'name' => ucwords($faker->word),
		    'position' => rand(0,10)
		    ));
		}
	}

}