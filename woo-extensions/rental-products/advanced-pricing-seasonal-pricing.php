<?php // only copy if needed!

/**
 * Adds an additional amount to the total if rental date range selected is during December 2025, for products with advanced pricing enabled
 * 
 * You can use amend this code to set your own date range, amount, and conditions
 *
 * @param float $total The calculated total of the product
 * @param array $data The advanced pricing data for the product
 *
 * @return float The modified total
 */
function kwp_rentals_advanced_pricing_seasonal_pricing( $total, $data ) {

    // This will effect all rentals, you may wish to add a condition here based on $data to target specific products, categories, etc

    if ( isset( $data['rent_from'] ) && isset( $data['rent_to'] ) ) {

        if ( '2025-12-01' <= $data['rent_from'] && '2025-12-31' >= $data['rent_to'] ) {

            // Adds $20 to the total if the rental period is between December 1st and December 31st 2025

            $total = $total + 20.00;

        }

    }

    return $total;
}
add_filter( 'wcrp_rental_products_advanced_pricing', 'kwp_rentals_advanced_pricing_seasonal_pricing', 10, 2 );