<?php // only copy if needed!

/**
 * This snippet applies a discount on the total for products with advanced pricing enabled, when a customer selects both Saturday and Sunday in their rental dates
 * 
 * This snippet checks if the product is rented over a weekend and applies a discount
 * based on the number of full weekends in the rental period. It calculates the total
 * number of days rented, counts the number of Saturdays and Sundays, and applies
 * a discount equal to the number of full weekends multiplied by the day rental price
 * 
 * e.g. Rental is $10 per day, if the product is rented over Saturday and Sunday this is charged at $10 for the weekend (not $20)
 * 
 * Important: This snippet is intended for use with day based rentals only, rentals that allow the customer to select 1,2,3,4+ days
 *
 * @param float $total The calculated total of the product
 * @param array $data The advanced pricing data for the product
 *
 * @return float The modified total
 */
function kwp_rentals_advanced_pricing_day_rental_full_weekend_discount( $total, $data ) {

    // This will effect all rentals, you may wish to add a condition here based on $data to target specific products, categories, etc

    if ( isset( $data['rent_from'] ) && isset( $data['rent_to'] ) ) {

        $current = strtotime( $data['rent_from'] );
        $last = strtotime( $data['rent_to'] );
        $days_total = 0;
        $saturdays = 0;
        $sundays = 0;

        while ( $current <= $last ) {

            $days_total = $days_total + 1;

            $day = gmdate( 'w', $current );

            if ( 0 == $day ) {

                $sundays = $sundays + 1;

            }

            if ( 6 == $day ) {

                $saturdays = $saturdays + 1;

            }

            $current = strtotime( '+1 day', $current );

        }

        if ( $saturdays > 0 && $sundays > 0 ) {

            $full_weekends = min( $saturdays, $sundays ); // Use min of both so a singular Saturday or Sunday isn't discounted
            $price_per_day = (float) $total / $days_total;
            $amount_to_discount = $full_weekends * $price_per_day;

            $total = $total - $amount_to_discount;

        }

    }

    return $total;
}
add_filter( 'wcrp_rental_products_advanced_pricing', 'kwp_rentals_advanced_pricing_day_rental_full_weekend_discount', 10, 2 );