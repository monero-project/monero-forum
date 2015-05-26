<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class Roles extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'roles:add';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Adds the appropriate roles and permissions.';

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
	 * Add all the roles and appoint appropriate people as administrators.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		
	 
	}

}
