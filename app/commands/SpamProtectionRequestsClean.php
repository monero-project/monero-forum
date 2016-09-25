<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Carbon\Carbon;

class SpamProtectionRequestsClean extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'spamprotectionrequests:clean';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clean cached SpamProtection validations older than 30 days.';

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
		DB::table('spamprotection_requests')->where('created_at', '<', Carbon::now()->subDays(30))->delete();

		$this->info('Successfully deleted all SpamProtection cached requests older than 30 days.');
	}


}
