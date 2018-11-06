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
	array( 'locid',	     'Location ID',          'txt' ),
	array( 'locid_old',  'Old Location ID',      'txt' ),
	array( 'latlon',     'Lat/Long Coordinates', 'txt' ),
	array( 'renewable',  'Subject to Renewal',   'bool' ),
	array( 'prev_email', 'Previous Email',       'txt' ),
	array( 'prev_fname', 'Previous First Name',  'txt' ),
	array( 'prev_lname', 'Previous Last Name',   'txt' ),
);

$rv_spot_custom_fields_define = function () use( $custom_rv_fields ) {
	foreach ($custom_rv_fields as $f) {
		$args = array(
			'id' => $f[0],
			'label' => $f[1],
			'desc_tip' => true,
			'description' => 'For RV spots only',
		);
		switch ($f[2]) {
			case 'bool':
				woocommerce_wp_checkbox( $args );
				break;
			default:
		woocommerce_wp_text_input( $args );
				break;
		}
	}
};
add_action( 'woocommerce_product_options_general_product_data', $rv_spot_custom_fields_define );

$rv_spot_custom_fields_save = function ( $post_id ) use( $custom_rv_fields ) {
	$product = wc_get_product( $post_id );
	foreach ($custom_rv_fields as $f) {
		$content = isset( $_POST[$f[0]] ) ? $_POST[$f[0]] : '';
		$product->update_meta_data( $f[0], sanitize_text_field( $content ) );
	}
	$product->save();
};
add_action( 'woocommerce_process_product_meta', $rv_spot_custom_fields_save );
