<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UsersClean extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'users:clean';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cleans users who have not activated their accounts for 7 days.';

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

		$date = new DateTime('7 days ago');
		$date->format('Y-m-d');

		$this->info('Getting inactive users');
		$users = User::where('confirmed', 0)->where('created_at', '<', $date);
		$count = $users->count();
		if($count == 0)
		{
			$this->info('Nothing to remove.');
			return 0;
		}
		else {
			$this->info('Deleting acquired users');
			$users->delete();
			$this->info($count . ' users removed successfully');
			return 0;
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
