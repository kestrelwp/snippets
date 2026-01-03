/**
 * Set minimum order amount for WooCommerce
 *
 * @link https://kestrelwp.com/docs/woocommerce-minimum-order-amount/
 */
add_action( 'woocommerce_check_cart_items', 'kestrel_minimum_order_amount' );
function kestrel_minimum_order_amount() {
    $minimum = 5; // Minimum order amount in your store's currency
    
    if ( WC()->cart->get_subtotal() < $minimum ) {
        wc_add_notice( 
            sprintf( 
                'Your order must be at least %s to checkout.', 
                wc_price( $minimum ) 
            ), 
            'error' 
        );
    }
}