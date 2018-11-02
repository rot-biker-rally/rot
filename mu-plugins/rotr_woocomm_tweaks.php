<?php

namespace rotr;

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

$custom_rv_fields = array(
	'locid' => 'Location ID',
	'locid_old' => 'Old Location ID',
	'latlon' => 'Lat/Long Coordinates',
);

$rv_spot_custom_fields_define = function () use( $custom_rv_fields ) {
	foreach ($custom_rv_fields as $k => $v) {
		$args = array(
			'id' => $k,
			'label' => $v,
			'desc_tip' => true,
			'description' => 'For RV spots only',
		);
		woocommerce_wp_text_input( $args );
	}
};
add_action( 'woocommerce_product_options_general_product_data', $rv_spot_custom_fields_define );

$rv_spot_custom_fields_save = function ( $post_id ) use( $custom_rv_fields ) {
	$product = wc_get_product( $post_id );
	foreach ($custom_rv_fields as $k => $v) {
		$title = isset( $_POST[$k] ) ? $_POST[$k] : '';
		$product->update_meta_data( $k, sanitize_text_field( $title ) );
	}
	$product->save();
};
add_action( 'woocommerce_process_product_meta', $rv_spot_custom_fields_save );
