<?php
/**
 * Created by PhpStorm.
 * User: Eddie
 * Date: 25/04/15
 * Time: 15:44
 */

namespace Eddieh\Kramdown;

use Symfony\Component\Process\Process as Process;
use Config;

class Kramdown {
	public static function string($string) {
		$filename = str_random(40);
		$filename = '../app/storage/kramdown/'.$filename.'.kd';

		file_put_contents($filename, $string);

		$process = new Process('ruby --external-encoding UTF-8 -S '.Config::get('kramdown.path').'kramdown '.$filename);
		$process->run();
		if (!$process->isSuccessful()) {
			throw new \RuntimeException($process->getErrorOutput());
		}
		unlink($filename);
		return $process->getOutput();
	}
}