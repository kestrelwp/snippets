<?php // only copy if needed!

/**
 * Update the WooCommerce tax_class based on the Lightspeed tax_class
 *
 * The "standard" tax rate in Woo is -> _tax_class = null
 * To set the tax rate to "Zero rate" ->  _tax_class = 'zero-rate'
 *
 * This example sets the 3rd tax class to "zero-rate"
 *
 */

function apply_ls_tax_class( $prod, $post_id ) {
	global $WCLSI, $wpdb;

	//uncommenting these two lines will look up and print the Lightspeed tax classes info to
	// the wclsi-error-logs. Run once, then comment it back out. Identify and use the tax class ID you need.

// 	$tax_classes = $WCLSI->make_api_call( 'Account/' . $WCLSI->ls_account_id . '/TaxClass/', 'Read');
// 	WCLSI_Logger::log_error( "tax classes: ", $tax_classes );

	//get the tax class from the wclsi product
	$tax_class_id = $prod->tax_class_id;

	//update the $tax_class value for the tax_class ID.
	$tax_class = null;
	switch ( $tax_class_id ) {
		case 1:
			// LS default is "Item" tax class
			break;
		case 2:
			// LS default is "Labor" tax class
			break;
		case 3:
			// first custom class
			$tax_class = 'zero-rate';
			break;
		default:
			break;
	}

	//sanitize the $post_id
	$prod_id = intval( $post_id );

	// Update _tax_class in postmeta
	update_post_meta( $prod_id, '_tax_class', $tax_class );

	// Update product meta lookup table directly
	$wpdb->update(
		$wpdb->wc_product_meta_lookup,
		[ 'tax_class' => $tax_class ],
		[ 'product_id' => $prod_id ]
	);
}

add_filter( 'wclsi_handle_product_taxonomy', 'apply_ls_tax_class', 10, 2 );