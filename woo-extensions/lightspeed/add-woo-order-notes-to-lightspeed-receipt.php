<?php // only copy if needed!

/**
 * Print the WooCommerce order's customer note on the Lightspeed R-Series receipt.
 *
 * Sends the customer's checkout note to the Lightspeed sale as both the printed
 * note (shows on the receipt) and the internal note (shows on the sale in Lightspeed).
 * The plugin does not set these by default.
 *
 * Requires Lightspeed POS for WooCommerce with R-Series sales sync enabled.
 * The kestrel_lightspeed_pos_r_series_sale_sync_payload filter is available in
 * plugin core (v3.2.1+), so this survives updates.
 *
 * Tips:
 *  - To print to only one field, set the other note's value to a single space ' '.
 *  - See the commented kwp_add_lightspeed_thank_you_note() below to prepend a
 *    canned thank-you message to the customer's note.
 */
function kwp_add_lightspeed_order_note( $data, $order ) {

	$note = $order->get_customer_note();

	if ( '' === trim( (string) $note ) ) {
		return $data;
	}

	$data['SaleNotes'] = array(
		'InternalNote' => array( 'note' => $note ),
		'PrintedNote'  => array( 'note' => $note ),
	);

	return $data;
}
add_filter( 'kestrel_lightspeed_pos_r_series_sale_sync_payload', 'kwp_add_lightspeed_order_note', 10, 2 );


/**
 * Variant: prepend a canned thank-you message to the customer's note.
 *
 * Use this INSTEAD of kwp_add_lightspeed_order_note() above (don't register both).
 */
/*
function kwp_add_lightspeed_thank_you_note( $data, $order ) {

	$thank_you = 'Thanks for shopping with us!';
	$customer  = trim( (string) $order->get_customer_note() );

	// Combine the thank-you and the customer note. Swap ' - ' for "\n" for a line break.
	$printed = $customer ? $thank_you . ' - ' . $customer : $thank_you;

	$data['SaleNotes'] = array(
		'InternalNote' => array( 'note' => $customer ? $customer : ' ' ),
		'PrintedNote'  => array( 'note' => $printed ),
	);

	return $data;
}
add_filter( 'kestrel_lightspeed_pos_r_series_sale_sync_payload', 'kwp_add_lightspeed_thank_you_note', 10, 2 );
*/
