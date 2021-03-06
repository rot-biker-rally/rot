<?php
/*
* Add your own functions here. You can also copy some of the theme functions into this file.
* Wordpress will use those functions instead of the original functions then.
*/
// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
// END ENQUEUE PARENT ACTION

add_theme_support( 'avia_custom_shop_page' );

function enqueue() {
	if ( is_admin() ) { return; }

	$js_deps = array();

	if( is_product_category( 'rv-spaces' ) || is_page( 'rv-space-renewal' )/* or other map pages */) {
		wp_enqueue_script( 'map-api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBQfsdeJ4vTR40cVrAF9P4T5dPss1vK7v4', null, false, true );
		wp_enqueue_script( 'map-style', get_stylesheet_directory_uri() . '/dist/js/map-style.js', null, false, true );
			$js_deps[] = 'map-api';
			$js_deps[] = 'map-style';
		wp_enqueue_script( 'map-utility', get_stylesheet_directory_uri() . '/dist/js/map-utility.js', $js_deps, false, true );
			$js_deps[] = 'map-utility';
	}

	if( is_product_category( 'rv-spaces' ) ) {
		wp_enqueue_script( 'map-index', get_stylesheet_directory_uri() . '/dist/js/map-index.js', $js_deps, false, true );
	}

	if( is_page( 'rv-space-renewal' ) ) {
		wp_enqueue_script( 'map-renewal', get_stylesheet_directory_uri() . '/dist/js/map-renewal.js', $js_deps, false, true );
	}

	if ( is_product() && ( has_term( 'rv-spaces' , 'product_cat') || has_term( 'tickets' , 'product_cat') ) ) {
		wp_enqueue_script( 'rotr-ui', get_stylesheet_directory_uri() . '/dist/js/ui.js', array( 'jquery' ), false, true );
	}

}

add_action( 'wp_enqueue_scripts', 'enqueue', 999 );

