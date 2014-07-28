<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ForumTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		$cats = Category::all();
		foreach ($cats as $category)
		{	
			$random = rand(1,10);
			for ($i = 0; $i < $random; $i++)
			{
			  $forum = Forum::create(array(
			    'name' => ucwords($faker->word),
			    'position' => rand(0,10),
			    'description' => $faker->text,
			    'category_id' => $category->id
			    ));
			}
		}
	}

}