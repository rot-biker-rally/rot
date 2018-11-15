<?php
/*
Plugin Name: ROT Rally WooCommerce Tweaks
Plugin URI: https://github.com/rot-biker-rally/rot-rally/blob/master/mu-plugins/rotr-woocomm-tweaks.php
Description: Augment WooCommerce data structure and adjust behavior
Version:     1.0
*/
namespace rotr;

$custom_rv_fields = array(
	array( 'public',      'Public Sale',           'bool' ),
	array( 'locid-old',   'Old Location ID',       'txt' ),
	array( 'lat',         'Latitude',              'txt' ),
	array( 'lon',         'Longitude',             'txt' ),
	array( 'renewable',   'Subject to Renewal',    'bool' ),
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

function mangle_query( $query ) {
	if ( $query->is_tax('product_cat', 'rv-spaces' ) ) {
		$query->query_vars['posts_per_page'] = -1;
	}
}
add_action( 'pre_get_posts', __NAMESPACE__.'\mangle_query' );

/**
 * Handle a custom 'renew-key' query var to get products with the 'renew-key' meta.
 * @param array $query - Args for WP_Query.
 * @param array $query_vars - Query vars from WC_Product_Query.
 * @return array modified $query
 */
function handle_custom_query_var( $query, $query_vars ) {
	if ( ! empty( $query_vars['renew-key'] ) ) {
		$query['meta_query'][] = array(
			'key' => 'renew-key',
			'value' => esc_attr( $query_vars['renew-key'] ),
		);
	}

	return $query;
}
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', __NAMESPACE__.'\handle_custom_query_var', 10, 2 );

function knockout_addons( $plugins ) {
	$req = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
	if ( strpos( $req, 'shop-item/4-day' ) ) {
		$v = 'woocommerce-product-addons-2.9.7/woocommerce-product-addons.php';
		$k = array_search( $v, $plugins );
		if ( $k !== false ) {
			unset( $plugins[$k] );
		}
	}
	return $plugins;
}
add_filter( 'option_active_plugins', __NAMESPACE__.'\knockout_addons' );

function rv_tax_title() {
	if( is_tax( 'product_cat', 'rv-spaces' ) ) {
		return true;
	}
}
add_filter( 'woocommerce_show_page_title', __NAMESPACE__.'\rv_tax_title' );

function rv_tax_desdcription() {
	if( is_tax( 'product_cat', 'rv-spaces' ) ) {
		echo(term_description( get_queried_object_id() ));
	}
}
add_action( 'woocommerce_archive_description', __NAMESPACE__.'\rv_tax_desdcription' );

/**
 * Add a standard $ value surcharge to all transactions in cart / checkout
 */
function add_processing_fee() {
	global $woocommerce;
	if ( is_admin() && ! defined( 'DOING_AJAX' ) )
		return;

	$woocommerce->cart->add_fee( 'Processing Fee', 2.95 );
}
add_action( 'woocommerce_cart_calculate_fees', __NAMESPACE__.'\add_processing_fee' );

/*
 * Causes WooCommerce Ticket product pages to stop redirecting to their event page
 * See https://theeventscalendar.com/knowledgebase/selling-tickets-from-the-woocommerce-products-page/
 */
function tribe_wootix_no_hijack() {
	if ( ! class_exists( '\Tribe__Tickets_Plus__Commerce__WooCommerce__Main' ) ) return;
	$woo_tickets = \Tribe__Tickets_Plus__Commerce__WooCommerce__Main::get_instance();
	remove_filter( 'post_type_link', array( $woo_tickets, 'hijack_ticket_link' ), 10, 4  );
}
add_action( 'init', __NAMESPACE__.'\tribe_wootix_no_hijack' );
