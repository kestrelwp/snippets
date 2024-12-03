<?php // Only copy this line if needed!

/**
 * Allows changing the default order updates text, "You’ll get shipping and delivery updates by email."
 *
 * @param string $order_updates_text Thank you page order updates text
 * 
 * @return string.
 */

function cfw_modify_order_updates_text( $order_updates_text ) {
	return $order_updates_text . "<br> If you have not received an email, please check your spam/junk folder." ;
}

add_filter('cfw_order_updates_text', 'cfw_modify_order_updates_text', 10, 1 );