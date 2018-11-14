<?php
namespace rotr;

global $wp_query;
$posts = $wp_query->posts;
$spots_json = spots_prep( $posts );
?>

<script>var points=<?=$spots_json?></script>
<div id="map"></div>
