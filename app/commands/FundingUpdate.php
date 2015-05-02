<?php

use Illuminate\Console\Command;
use Eddieh\Monero\Monero;


class FundingUpdate extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'funding:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Updates the funding data.';

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
		$this->info('Updating the funding data.');
		$funding = Funding::all();
		$this->info('Receiving funds.');
		$monero = new Monero;
		$monero->clientReceive();
		$this->info('Funds received.');
		$this->info('Updating cache.');
		foreach($funding as $thread)
		{
			//clear the cache items
			if(Cache::has($thread->thread_id . '_funding_percentage'))
			{
				$this->info('Percentage cache cleared.');
				Cache::forget($thread->thread_id . '_funding_percentage');
			}
			if(Cache::has($thread->thread_id . '_funding_contributions'))
			{
				Cache::forget($thread->thread_id . '_funding_contributions');
			}
			if(Cache::has($thread->thread_id . '_funding_funded'))
			{
				Cache::forget($thread->thread_id . '_funding_funded');
			}
		}
		$this->info('Update complete!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
