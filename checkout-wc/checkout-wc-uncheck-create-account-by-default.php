<?php // Only copy this line if needed!

/**
 * Decide whether the "Create account" checkbox should be
 * checked or unchecked by default when the page loads and
 * when a customer enters their email address.
 * 
 * Return false to leave the checkbox Unchecked.
 * 
 * @return bool.
 */

/**
 * Filter source: https://github.com/kestrelwp/checkout-for-woocommerce/blob/0461630163b70d2876aa352f23462f012a845cef/includes/Managers/AssetManager.php#L476.
 */

add_filter( 'cfw_check_create_account_by_default', '__return_false' );