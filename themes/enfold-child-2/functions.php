<?php
/*
* Add your own functions here. You can also copy some of the theme functions into this file.
* Wordpress will use those functions instead of the original functions then.
*/
// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:
namespace {

add_theme_support( 'avia_custom_shop_page' );

}


namespace rotr {

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

function checkout_coupon_yank()
{
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}
add_action( 'woocommerce_before_checkout_form', __NAMESPACE__.'\checkout_coupon_yank', 9 );

function checkout_coupon_stuff()
{
    add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_coupon_form', 10 );
}
add_action( 'woocommerce_checkout_after_customer_details', __NAMESPACE__.'\checkout_coupon_stuff', 9 );

} //namespace rotr

// END ENQUEUE PARENT ACTION
