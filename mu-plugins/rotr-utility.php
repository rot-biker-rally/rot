<?php
/*
Plugin Name: ROT Rally Utilities
Plugin URI: https://github.com/rot-biker-rally/rot-rally/blob/master/mu-plugins/rotr-utility.php
Description: Configure ACF operation
Version:     1.0
*/
namespace rotr;

function p($x) {
	echo('<pre>');
	print_r($x);
	echo('</pre>');
}
