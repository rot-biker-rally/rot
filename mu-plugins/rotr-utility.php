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

function spots_retrieve() {
	$args = array(
		'post_type' => 'product',
		'tax_query' => array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => 'rv-spaces'
		),
		'meta_key' => 'public',
		'meta_value' => 'yes',
		'posts_per_page' => -1
	);
	$q = new \WP_Query( $args );
	return $q->posts;
}

function spots_prep($posts) {
	$r = array();
	foreach ( $posts as $p ) {
		$m = get_post_meta( $p->ID );
		$r[] = array(
			'title'     => $p->post_title,
			'lat'       => $m['lat'][0],
			'lon'       => $m['lon'][0],
			'sku'       => $m['_sku'][0],
			'stock'     => (int) $m['_stock'][0],
			'renewable' => ($m['renewable'][0] == 'yes') ? 1 : 0,
			'link'      => get_permalink($p->ID),
		);
	}
	return json_encode($r, JSON_UNESCAPED_SLASHES);
}
