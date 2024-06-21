<?php // only copy if needed!


/**
 * Adds a link to the WooCommerce thank you page in order emails.
 *
 * @param \WC_Order $order the order object
 */
function kwp_add_email_order_page_link( $order ) {

	if ( $order instanceof WC_Order ) {

		$args = array(
			'order-received' => $order->get_id(),
			'key'            => $order->get_order_key(),
		);

		ob_start();
		?>
		<div style="margin-bottom: 40px;">
			<p><?php esc_html_e( 'You can view the status of this order at any time by visiting the confirmation page.', 'textdomain' ); ?>
			<?php printf( '<a class="button" href="%s">%s</a>',
				esc_url( add_query_arg( $args, wc_get_checkout_url() ) ),
				__( 'View Order', 'textdomain' )
			); ?></p>
		</div>
		<?php

		echo ob_get_clean();
	}
}
add_action( 'woocommerce_email_after_order_table', 'kwp_add_email_order_page_link' );


/**
 * Styles the link to the WooCommerce thank you page in order emails.
 *
 * @param string $styles the email CSS
 * @return string updated styles
 */
function kwp_add_email_styles( $styles ) {
	
	$base      = get_option( 'woocommerce_email_base_color' );
	$base_text = wc_light_or_dark( $base, '#202020', '#ffffff' );

	$styles .= 'a.button {
		background-color: ' . esc_attr( $base ) . ';
		border: 0;
		color: ' . esc_attr( $base_text ) . ';
		display: block;
		font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
		font-weight: bold;
		margin-top: 10px;
		padding: 10px 15px;
		text-decoration: none;
		width: fit-content;
	}';

	return $styles;
}
add_filter( 'woocommerce_email_styles', 'kwp_add_email_styles' );