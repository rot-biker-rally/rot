<?php
/*
* Add your own functions here. You can also copy some of the theme functions into this file.
* Wordpress will use those functions instead of the original functions then.
*/
// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

add_theme_support( 'avia_custom_shop_page' );

function enqueue() {
	if ( is_admin() ) { return; }

	$js_deps = array( 'jquery' );

	if( is_tax('product_cat', 'rv-spaces' ) ) {
		wp_enqueue_script( 'map-index', get_stylesheet_directory_uri() . '/dist/js/map-index.js', false, true );
	}
}

add_action( 'wp_enqueue_scripts', 'enqueue', 999 );

// END ENQUEUE PARENT ACTION
