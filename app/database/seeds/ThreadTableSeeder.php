<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ThreadTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		$forums = Forum::all();
		foreach($forums as $forum)
		{
			$rand = rand(1, 10);
			for ($i = 0; $i < $rand; $i++)
			{
			  $user = User::orderBy(DB::raw('RAND()'))->first();
			  $thread = Thread::create(array(
			    'name' => $faker->bs,
			    'user_id' => $user->id,
			    'forum_id' => $forum->id
			  ));
			}
		}
	}

}