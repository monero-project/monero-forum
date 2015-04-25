<?php
/**
 * Created by PhpStorm.
 * User: Eddie
 * Date: 25/04/15
 * Time: 15:44
 */

namespace Eddieh\Kramdown;

class Kramdown {
	public static function string($string) {
		$string = addslashes($string);
		$ruby_script = "
			require 'kramdown' \r\n
			text = '".$string."' \r\n
			puts Kramdown::Document.new(text, :remove_html_tags => true).to_html
		";

		$filename = str_random(40);
		$filename = '../app/storage/kramdown/'.$filename.'.rb';
		file_put_contents($filename, $ruby_script);
		$html = system('ruby '.$filename);
		unlink($filename);
		return $html;
	}
}