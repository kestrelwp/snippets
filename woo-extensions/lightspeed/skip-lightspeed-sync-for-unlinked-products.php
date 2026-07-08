<?php // only copy if needed!

/**
 * Skip syncing an order to Lightspeed R-Series if it contains any product
 * that isn't linked to a Lightspeed item.
 *
 * By default the plugin will still sync a sale even when some line items aren't
 * linked to Lightspeed, which can produce a partial/incorrect sale in Lightspeed
 * that then has to be voided by hand. This snippet blocks the whole order from
 * syncing if ANY line item is unlinked, and leaves an order note + log entry.
 *
 * R-Series only. (X-Series already skips unsynced line items.)
 *
 * Registered at priority 999 so it runs AFTER add-on line snippets such as the
 * "add shipping as a sale line" snippet (priority 10) — otherwise that snippet
 * would repopulate the payload and defeat the block.
 */
function kwp_skip_unlinked_lightspeed_sale( $sale_lines, $shipping_total, $ls_tax_id, $order ) {

	if ( ! $order instanceof WC_Order ) {
		return $sale_lines;
	}

	if ( ! empty( $sale_lines['unlinked_items'] ) && is_array( $sale_lines['unlinked_items'] ) ) {
		foreach ( $sale_lines['unlinked_items'] as $item ) {
			if ( is_object( $item ) ) {
				$msg = 'Prevented order from syncing to Lightspeed: it contains products not linked to Lightspeed.';
				$order->add_order_note( $msg );
				if ( class_exists( 'WCLSI_Logger' ) ) {
					WCLSI_Logger::log_error( $msg . ' Order: ', $order->get_id() );
				}
				return array(); // empty payload -> the sale is not sent
			}
		}
	}

	return $sale_lines;
}
add_filter( 'wclsi_build_sale_lines', 'kwp_skip_unlinked_lightspeed_sale', 999, 4 );
