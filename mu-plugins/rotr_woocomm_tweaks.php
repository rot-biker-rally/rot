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
