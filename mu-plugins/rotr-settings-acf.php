<?php
/*
Plugin Name: ROT Rally ACF Settings
Plugin URI: https://github.com/rot-biker-rally/rot-rally/blob/master/mu-plugins/rotr-settings-acf.php
Description: Configure ACF operation
Version:     1.0
*/
namespace rotr;

add_filter( 'acf/settings/save_json', __NAMESPACE__.'\acf_json_save_point' );
add_filter( 'acf/settings/load_json', __NAMESPACE__.'\acf_json_load_point' );

// Save ACF settings locally in a JSON file.
function acf_json_save_point( $path ) {
	// update path
	$path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/acf';
	return $path;
}

// Read ACF settings from the local JSON file.
function acf_json_load_point( $paths ) {
	// remove original path (optional)
	unset( $paths[0] );
	// append path
	$paths[] = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/acf';
	return $paths;
}
