<?php
/**
 * CheckoutWC - Hide the Shipping option for certain product categories
 *
 * In CheckoutWC's Delivery Method step, hides the Shipping option entirely when
 * at least one product in the cart belongs to a given category. Useful for
 * pickup-only or non-shippable categories.
 *
 * Note: this also hides the Shipping option for mixed carts. If the cart holds
 * a product from the target (non-shippable) category alongside a shippable one,
 * the Shipping option is still hidden.
 *
 * Works for both simple and variable products. Variations do not carry their own
 * category terms, so for a variation we check the parent product's ID.
 *
 * @author      Obi Juan <hola@obijuan.dev> (https://obijuan.dev)
 * @contributor Wojtek Hoch (variable product support)
 * @contributor Ingar Bekkelund, ETI Norge (reported the variable-product category bug)
 * @see         https://www.checkoutwc.com/documentation/local-pickup-how-to-hide-the-shipping-option-for-certain-product-categories/
 */

/**
 * Check whether any product in the cart belongs to a specific category.
 *
 * @param string $category_slug The product category slug (e.g. "Cat 1" > "cat-1").
 * @return bool True if at least one cart item is in the category, false otherwise.
 */
function is_product_of_category_in_cart( $category_slug ) {
	if ( WC()->cart && ! WC()->cart->is_empty() ) {
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$product = $cart_item['data'];

			// Determine which product ID actually holds the category.
			// Variations don't carry categories, so use the parent product's ID.
			if ( $product->get_type() === 'variation' ) {
				$checked_product_id = $product->get_parent_id();
			} else {
				$checked_product_id = $product->get_id();
			}

			if ( has_term( $category_slug, 'product_cat', $checked_product_id ) ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Disable the Shipping option when the target category is in the cart.
 *
 * @filter cfw_local_pickup_disable_shipping_option
 */
add_filter( 'cfw_local_pickup_disable_shipping_option', function () {
	$category = 'your-category-slug'; // Change this to your category slug.

	return is_product_of_category_in_cart( $category );
} );
