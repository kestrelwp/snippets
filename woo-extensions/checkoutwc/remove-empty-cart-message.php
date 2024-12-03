<?php // Only copy this line if needed!

/**
 * Remove the "Your Cart is Empty" message from the Side Cart.
 * 
 * Please note, if you are logged in and have viewed the cart before, you may need to clear cart sessions,
 * or test from an incognito window to avoid cached data.
 * 
 */

function cfw_remove_output_empty_cart_message() {
	// Remove the empty cart message hook
	remove_action( 'woocommerce_cart_is_empty', 'cfw_output_empty_cart_message', 1 );
}

add_action( 'wp', 'cfw_remove_output_empty_cart_message', 99 );