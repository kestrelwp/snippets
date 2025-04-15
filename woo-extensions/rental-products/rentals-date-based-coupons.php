<?php // only copy if needed!

/**
 * Make a coupon code only discount if the rental dates are within a specific range
 * 
 * @param  $NumberUtil::round
 * @param  $discounting_amount
 * @param  $cart_item
 * @param  $single
 * @param  $that
 * 
 * @return $discounting_amount
 */
function kwp_rentals_date_based_coupons( $discounting_amount, $price_to_discount, $cart_item, $single, $coupon ) {

    // If it is a rental

    if ( isset( $cart_item['wcrp_rental_products_rent_from'] ) && isset( $cart_item['wcrp_rental_products_rent_to'] ) ) {

        // If coupon code matches, e.g. test

        if ( 'test' == $coupon->get_code() ) {

            // If the dates are outside the date range then do not apply the discounting amount

            if ( $cart_item['wcrp_rental_products_rent_from'] < '2025-08-01' || $cart_item['wcrp_rental_products_rent_to'] > '2025-08-31' ) {

                // e.g. if the rental is from 2025-07-01 to 2025-07-05, then do not apply the discount
                // e.g. if the rental is from 2025-08-01 to 2025-08-05, then apply the discount

                $discounting_amount = 0;

            }

        }

    }

    return $discounting_amount;
}
add_filter( 'woocommerce_coupon_get_discount_amount', 'kwp_rentals_date_based_coupons', 10, 5 );