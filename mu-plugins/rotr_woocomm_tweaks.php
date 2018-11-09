<?php
namespace rotr;

$custom_rv_fields = array(
	array( 'public',      'Public Sale',           'bool' ),
	array( 'locid',	     'Location ID',          'txt' ),
	array( 'locid-old',   'Old Location ID',       'txt' ),
	array( 'lat',         'Latitude',              'txt' ),
	array( 'lon',         'Longitude',             'txt' ),
	array( 'renewable',  'Subject to Renewal',   'bool' ),
	array( 'renew-email', 'Renewal Email',         'txt' ),
	array( 'renew-fname', 'Renewal First Name',    'txt' ),
	array( 'renew-lname', 'Renewal Last Name',     'txt' ),
	array( 'renew-key',   'Renewal Key',           'txt' ),
	array( 'vendor',      'Earmarked for Vendors', 'bool' ),
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
