<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();
		
		$faker = Faker::create();
		foreach(Thread::all() as $thread)
		{
			$rand = rand(300, 350);
			for ($i = 0; $i < $rand; $i++)
			{
			  $user = User::orderBy(DB::raw('RAND()'))->first();
			  $post = Post::create(array(
			    'user_id' => $user->id,
			    'thread_id' => $thread->id,
			    'body' => $faker->text,
			    'weight'	=> 500
			  ));
			}
			$thread->touch();
			$thread->save();
		}
	}

}