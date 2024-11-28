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

add_filter( 'cfw_check_create_account_by_default', '__return_false' );
