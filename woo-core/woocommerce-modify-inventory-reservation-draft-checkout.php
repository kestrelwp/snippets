<?php // only copy if needed!

/**
 * Change inventory reservation for draft checkouts to 30 minutes (default: 10)
 * Read more: https://kestrelwp.com/blog/woocommerce-inventory-reservations-checkout/
 *
 * @param int $duration the inventory reservation duration, in minutes
 *
 * @return int duration
 */
add_filter( 'woocommerce_order_hold_stock_minutes', function ( $duration ) {

	// only change for draft checkouts, which have duration = 10 min
	if ( 10 === $duration ) {
		return 30;
	}

} );