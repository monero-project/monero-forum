<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class OTCUpdate extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'otcupdate:get';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Downloads the Bitcoin-OTC database.';

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
		//lock the site		
		$this->info('Switching to Maintenance Mode');
		echo exec('php artisan down');
		
		$this->info('Starting the Ratings database download');
		chdir(Config::get('app.project_dir').'/app/database');
		echo exec('wget --quiet http://bitcoin-otc.com/otc/RatingSystem.db');
		
		$this->info('Switching the Ratings database');
		echo exec('rm ratings.db');
		echo exec('mv RatingSystem.db ratings.db');
		
		$this->info('Starting the GPG Key database download');
		echo exec('wget --quiet http://bitcoin-otc.com/otc/GPG.db');
		
		$this->info('Switching the GPG Key database');
		echo exec('rm gpg.db');
		echo exec('mv GPG.db gpg.db');
		
		$this->info('Switching back from Maintenance Mode');
		chdir(Config::get('app.project_dir'));
		echo exec('php artisan up');
		
		$this->info('Done!');
		
	}

}
