<?php
/**
 * Created by PhpStorm.
 * User: Eddie
 * Date: 25/04/15
 * Time: 15:49
 */

namespace Eddieh\Kramdown\Facades;

use Illuminate\Support\Facades\Facade;

class Kramdown extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'kramdown'; }

}