<?php
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
