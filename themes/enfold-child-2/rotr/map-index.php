<?php namespace rotr; ?>

<div id="map"></div>

<?php
function p($x) {
	echo('<pre>');
	print_r($x);
	echo('</pre>');
}

global $wp_query;
$posts = $wp_query->posts;
	// var_dump($posts[0]);
	// var_dump(get_post_meta( $posts[0]->ID ));
$r = array();
foreach ( $posts as $p ) {
	$m = get_post_meta( $p->ID );
	$r[] = array(
		'id'        => $p->ID,
		'slug'      => $p->post_name,
		'title'     => $p->post_title,
		'lat'       => $m['lat'][0],
		'lon'       => $m['lon'][0],
		'sku'       => $m['_sku'][0],
		'stock'     => (int) $m['_stock'][0],
		'renewable' => ($m['renewable'][0] == 'yes') ? 1 : 0,
		'link'      => get_permalink($p->ID),
	);
}
$spot_json = json_encode(array_slice($r, 0, 3), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
p($spot_json);
	// file_put_contents('wp-content/themes/enfold-child-2/woocommerce/spots.csv', $spot_json);
