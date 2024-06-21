<?php // only copy if needed!

/**
 * Remove inventory reservation for draft checkouts
 * Read more: https://kestrelwp.com/blog/woocommerce-inventory-reservations-checkout/
 */
add_filter( 'woocommerce_hold_stock_for_checkout', '__return_false' );