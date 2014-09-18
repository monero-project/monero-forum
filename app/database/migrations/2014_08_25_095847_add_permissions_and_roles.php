<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPermissionsAndRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$member = new Role;
		$member->name = 'Member';
		$member->save();
		
		$mod = new Role;
		$mod->name = 'Moderator';
		$mod->save();
		
		$admin = new Role;
		$admin->name = 'Admin';
		$admin->save();
		
		$admin_panel = new Permission;
		$admin_panel->name = 'admin_panel';
		$admin_panel->display_name = 'Administrator Panel Access';
		$admin_panel->save();
		
		$admin->perms()->sync(array($admin_panel->id));
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
