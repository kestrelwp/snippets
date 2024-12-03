<?php // Only copy this line if needed!

/**
 * The output of CheckoutWC is controlled by the template-hooks.php file. It's possible to move items around
 * the page by removing the given actions from one section, and moving to another - or adjusting the priority.
 * 
 * This example moves the order notes field from the Payment Method section to the Customer Info section.
 * 
 */

function cfw_move_order_notes_to_customer_info() {
    // Remove the original action
    remove_action( 'cfw_checkout_payment_method_tab', 'cfw_payment_tab_content_order_notes', 30 );
    // Add it back in for the new location
    add_action( 'cfw_checkout_customer_info_tab', 'cfw_payment_tab_content_order_notes', 45 );
}

add_action( 'wp', 'cfw_move_order_notes_to_customer_info' );