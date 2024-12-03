<?php // Only copy this line if needed!

/**
 * Allows changing the default sidecart order button text, as well as other message data.
 *
 * @param string $data the event data containing the messages
 * 
 * @return string.
 */

function cfw_modify_sidecart_button_text( $data ) {
    $data['messages']['proceed_to_checkout_label'] = 'Checkout';
	
	return $data;
}

add_filter( 'cfw_side_cart_event_object', 'cfw_modify_sidecart_button_text', 10, 1);