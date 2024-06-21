<?php // only copy if needed!

// Makes all WooCommerce orders (even paid) editable by admins / shop managers
add_filter( 'wc_order_is_editable', '__return_true' );