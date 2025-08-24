<?php // only copy if needed!

/**
 * Adds a product to LS orders to include WooCommerce Fee totals
 *
 * Setup:
 *  1. Create a new simple product in Lightpseed called "Woo Fees" Leave the price at $0.
 *		Turn on negative inventory module in LS settings, or set inventory for shipping product at the maximum.
 *		The product does not need to be synced to WooCommerce. It is ok if it is, but it does not need to be customer facing.
 *
 *  2. Note the LS product ID. This can be found in the URL of the Lightspeed product
 *		example: https://us.merchantos.com/?name=item.views.item&form_name=view&id=1609&tab=details
 *		For this example, we will enter the $ls_product_id = 1609
 *			If the product synced to Woo, the LS Item ID is shown when hovering your mouse over the product on the Lightpseed Importer table
 *
 *  3. 	Replace "null" on line 54 with the LS product ID.
 *	 	ex.	$ls_product_id = 1609;
 */

function update_fees_to_remove_from_payment ( $fees, $order ) {
	$filtered = array();

	// Return an array of any fees in the Woo order that should NOT sync to Lightspeed.
	// Any fees added as a line item in the "add_fee_sale_line" function should NOT be included in the return

	// $fees is an array of WC_Order_Item_Fee objects that will have their totals removed from the payment amount sent to Lightspeed
	// Return the (possibly) modified array.
	// e.g. Don't send fees whose name contains "import":
	/*
	$filtered = array();
	foreach ( $fees as $fee_item ) {
		if ( stripos( $fee_item->get_name(), 'import' ) !== false ) {
			$filtered[] = $fee_item;
		}
	}
	return $filtered;
	*/

	// If no object ID is set for the Woo Fees to be synced to, we will remove all fees from the order syncing so it doesn't fail.
	if ( wp_cache_get( 'wclsi_remove_fee_payment', WCLSI_CACHE ) ) {
		wp_cache_delete( 'wclsi_remove_fee_payment', WCLSI_CACHE );
		return $fees;
	}

	// Default: return empty array. This will include all order fees in the order synced to Lightspeed.
	return $filtered;
}

add_filter( 'wclsi_fees_to_remove_from_ls_payment', 'update_fees_to_remove_from_payment', 10, 2 );

function add_fee_sale_line ( $sale_lines, $shipping_total, $tax_id, $order ) {

	// YOU MUST ENTER THE LS PRODUCT ID HERE. See the Setup info above for more information.
	$ls_fee_product_id = null;

	if ( ! isset( $ls_fee_product_id ) ) {
		$msg = "no fee product is set. Visit the Fee Snippet and update the ls_fee_product_id variable to equal your LS product ID for the WooCommerce Fees product ";
		WCLSI_Logger::log_error( $msg, '' );
		wp_cache_set( 'wclsi_remove_fee_payment', true, WCLSI_CACHE, 10 );
		return $sale_lines;
	}

	$total_fees     = 0;
	$total_fee_tax  = 0;

	foreach ( $order->get_items( 'fee' ) as $item_fee ) {

		$total_fees    += (float) $item_fee->get_total();
		$total_fee_tax += (float) $item_fee->get_total_tax();
	}

	$total_fees = round( $total_fees, 2 );
	$total_fee_tax = round( $total_fee_tax, 2 );


	if ( $total_fees > 0 ) {

		$fees_line = [];

		$fees_line['tax'] = 'false';

		if ( isset( $tax_id ) && $total_fee_tax > 0 ) {
			$fees_line['tax'] = 'true';
			$fees_line['taxCategoryID'] = $tax_id;
		}

		$fees_line['name'] = "Woo Fees";
		$fees_line['unitQuantity'] = 1;
		$fees_line['itemID'] = $ls_fee_product_id;
		$fees_line['unitPrice'] = $total_fees;

		$sale_lines['SaleLine'][] = $fees_line;

	}

	return $sale_lines;
}

add_filter( 'wclsi_build_sale_lines', 'add_fee_sale_line', 10, 4 );



// This is an example of how you may add a fee to your items when added to the cart

function add_cart_fee( $cart ) {
	$fee_total = 0;

	// add Fee name
	$fee_name = 'Import Fee';

	// adjust the fee rate here. this example is a 25% fee, input as .25
	$fee_rate = 0.25;

	// This is what the customer will see the fee named in the cart
	// Default: "25% Import Fee"
	$fee_msg = ( $fee_rate * 100 ) . '% ' . $fee_name;

	foreach ( $cart->get_cart() as $cart_item ) {
		$product = $cart_item['data'];

		// add criteria that you want to add fees to. This example is using Woo categories
		$criteria1 = has_term( 42, 'product_cat', $product->get_id() ) ? true : false;
		$criteria2 = has_term( 781, 'product_cat', $product->get_id() ) ? true : false;

		if ( $criteria1 || $criteria2 ) {

			$price = $product->get_price() * $cart_item['quantity'];
			$fee = $price * $fee_rate;

			// Rounding is required because Lightspeed does its own tax calculation on the total.
			// Round now to have Woo calculate tax on the rounded amount like Lightspeed will.
			$fee_total += round( $fee, 2 );
		}

	}

	if ( $fee_total > 0 ) {
		$cart->add_fee( $fee_msg, $fee_total, false ); //false adds the fee with no tax.
	}
}
add_action( 'woocommerce_cart_calculate_fees', 'add_cart_fee' );