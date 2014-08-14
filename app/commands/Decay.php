<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Decay extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'decay:down';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Decays down the posts.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info("Decaying the posts.");
		DB::table('posts')->decrement('weight', Config::get('app.decay_weight'));
		$this->info("Done!");
	}

}
