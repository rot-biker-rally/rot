<?php
/*
Plugin Name: ROT Rally ACF Shortcodes
Plugin URI: https://github.com/rot-biker-rally/rot-rally/blob/master/mu-plugins/rotr-shortcodes.php
Description: Define custom shortcodes
Version:     1.0
*/
namespace rotr;

function show_product( $atts )
{
	$p = new \WC_Product( $atts['id'] );
	return '<a href="'.$p->get_permalink().'"">'.$p->get_image().'</a>';
}
add_shortcode( 'rr_product', __NAMESPACE__.'\show_product' );

function show_category( $atts )
{
	$img = wp_get_attachment_image_src( get_woocommerce_term_meta( $atts['id'], 'thumbnail_id' ), 'shop_catalog' )[0];
	return '<a href="'.get_term_link((int)$atts['id']).'""><img src="'.$img.'"></a>';
}
add_shortcode( 'rr_category', __NAMESPACE__.'\show_category' );
