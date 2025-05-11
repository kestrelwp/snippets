<?php // only copy if needed!

/**
 * Adds a product to LS orders to include WooCommerce Shipping totals
 *
 *
 * Setup:
 *  1. Create a new simple product in Lightpseed called "Woo Shipping." Leave the price at $0.
 *		Turn on negative inventory module in LS settings, or set inventory for shipping product at the maximum.
 *		The product does not need to be synced to WooCommerce. It is ok if it is, but it does not need to be customer facing.
 *
 *  2. Note the LS product ID. This can be found in the URL of the Lightspeed product
 *		example: https://us.merchantos.com/?name=item.views.item&form_name=view&id=1375&tab=details
 *		For this example, we will enter the $ls_product_id = 1375
 *			If the product synced to Woo, the LS Item ID is shown when hovering your mouse over the product on the Lightpseed Importer table
 *
 *  3. Replace "null" on line 25 with the LS product ID.
 *			$ls_product_id = 1375;
 */


function add_ls_shipping_product ( $sale_lines, $shipping_total, $tax_id ) {

	// ** replace "null" with the Lightspeed ID of the shipping product here **
	$ls_product_id = null;

	if ( ! isset( $ls_product_id ) ) {
		return $sale_lines;
	}
	wp_cache_set( 'wclsi_add_shipping_payment', true, WCLSI_CACHE, 10 );

	if ( $shipping_total > 0 ) {
		$shipping_line = [];

		if ( ! isset( $tax_id ) ) {
			$shipping_line['tax'] = 'false';
		} else {
			$shipping_line['taxCategoryID'] = $tax_id;
		}

		$shipping_line['name'] = "Woo Shipping";
		$shipping_line['unitQuantity'] = 1;
		$shipping_line['itemID'] = $ls_product_id;
		$shipping_line['unitPrice'] = $shipping_total;

		$sale_lines['SaleLine'][] = $shipping_line;
	}

	return $sale_lines;
}

add_filter( 'wclsi_build_sale_lines', 'add_ls_shipping_product', 10, 3 );


//update the payment calculation to include shipping costs

function include_ls_shipping_payment( $payment, $shipping_total, $shipping_tax ) {

	if ( wp_cache_get( 'wclsi_add_shipping_payment', WCLSI_CACHE ) ) {
		$payment += $shipping_total + $shipping_tax;
		wp_cache_delete( 'wclsi_add_shipping_payment', WCLSI_CACHE );
	}

	return $payment;
}

add_filter( 'wclsi_calc_sale_payment', 'include_ls_shipping_payment', 10, 3 );