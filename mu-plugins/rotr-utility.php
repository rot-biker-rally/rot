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
			'terms' => 'rv-spaces',
		),
		'meta_key' => 'public',
		'meta_value' => 'yes',
		'posts_per_page' => -1,
	);
	$q = new \WP_Query( $args );
	return $q->posts;
}

function boolify( $x ) {
	$truths = array( 'yes', 'true' );
	return in_array( $x, $truths );
}

function att_parse( $att, $flag ) {
	$flag = boolify($flag);
	return ($flag) ? $att : $flag;
}

function spots_prep( $posts ) {
	$taxes_atts = array( 'pa_jumbo', 'pa_electric', 'pa_parade' );
	$taxes = array_flip( array_merge( array( 'pa_lot' ), $taxes_atts ) );
	$tax_deets = get_taxonomies( null, 'objects' );
	foreach ( $taxes as $k => &$v ) {
		$v = $tax_deets[$k]->labels->singular_name;
	}

	$r = array();
	foreach ( $posts as $p ) {
		$pid = $p->ID;

		$atts_raw = get_the_terms( $pid, array_keys( $taxes ) );
		$a = array();
		foreach ( $atts_raw as $att ) {
			$a[$att->taxonomy] = $att->slug;
		}

		$atts_bundle = array();
		foreach ($taxes_atts as $t ) {
			$att_add = att_parse( $taxes[$t], $a[$t] );
			if ( $att_add ) {
				$atts_bundle[] = $att_add;
			}
		}
		array_unshift( $atts_bundle, ucfirst( $a['pa_lot'] ).' Lot' );

		$m = get_post_meta( $pid );

		$r[] = array(
			'title'     => $p->post_title,
			'sku'       => $m['_sku'][0],
			'stock'     => (int) $m['_stock'][0],
			'renewable' => boolify($m['renewable'][0]),
			'price'     => $m['_price'][0],
			'locid_old' => $m['locid-old'][0],
			'link'      => get_permalink( $pid ),
			'lat'       => $m['lat'][0],
			'lon'       => $m['lon'][0],
			'atts'      => $atts_bundle,
		);
	}
	return json_encode($r, JSON_UNESCAPED_SLASHES);
}
