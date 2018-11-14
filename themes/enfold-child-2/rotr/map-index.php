<?php
namespace rotr;

global $wp_query;
$posts = $wp_query->posts;
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
$spots_json = json_encode($r, JSON_UNESCAPED_SLASHES);
?>

<script>var points=<?=$spots_json?></script>
<div id="map"></div>
