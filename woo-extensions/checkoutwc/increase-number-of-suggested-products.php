<?php // Only copy this line if needed!

/**
 * CheckoutWC enables merchants to show suggested products on the side cart.
 * 
 * By default, the limit is 3 products. This snippet increases the number of suggested products to 10.
 * 
 */

function cfw_increase_number_of_suggested_products( $cross_sells ) {
    // Adjust this number to the desired limit
    $new_limit = 10;

	$cart_item_ids = array();
	foreach ( WC()->cart->get_cart() as $cart_item ) {
		$product = $cart_item['data'];
		$cart_item_ids[] = $product->get_id();
	}
	
    // Other parameters can be adjusted here as needed, if different suggested products are desired
	$cross_sells = wc_get_products(
				array(
					'limit'        => $new_limit,
					'exclude'      => $cart_item_ids,
					'status'       => 'publish',
					'orderby'      => 'rand',
					'stock_status' => 'instock',
				)
			);
	return $cross_sells;
}

add_filter( 'cfw_get_suggested_products', 'cfw_increase_number_of_suggested_products', 10, 1 );