/**
 * Apply a percentage‑based shipping discount as a negative fee for use with the CheckoutWC shipping threshold feature.
 *
 * When the cart subtotal meets or exceeds the configured threshold,
 * WooCommerce adds a fee line (negative value) to offset a portion of
 * the current shipping total. Works with side‑cart fragments because
 * fees always recalc on AJAX updates.
 *
 * Hook: woocommerce_cart_calculate_fees
 *
 * @param WC_Cart $cart The WooCommerce cart object.
 *
 * @return void
 */

function kestrel_shipping_discount_fee( $cart ) {

	// ── CONFIG ────────────────────────────────────────────────
	$discount_threshold = 100;   // dollars — trigger point
	$discount_modifier  = 0.50;  // fraction — 0.50 = 50 % off
	$fee_label          = __( 'Shipping Discount', 'checkout-wc' );
	// ─────────────────────────────────────────────────────────

	if ( $cart->is_empty() || $cart->subtotal < $discount_threshold ) {
		return; // Nothing to do.
	}

	// Current shipping cost for the cart (before any taxes/fees).
	$shipping_total = (float) $cart->get_shipping_total();

	// Discount = shipping_total * (1 – modifier). Example: 50 % off.
	$discount_amount = $shipping_total * ( 1 - $discount_modifier );

	if ( $discount_amount > 0 ) {
		// Add a non‑taxable negative fee to offset shipping.
		$cart->add_fee( $fee_label, -$discount_amount, false );
	}
}

add_action( 'woocommerce_cart_calculate_fees', 'kestrel_shipping_discount_fee', 20 );
