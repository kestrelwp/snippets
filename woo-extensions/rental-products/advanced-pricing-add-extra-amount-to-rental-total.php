<?php // only copy if needed!

/**
 * Add an extra amount to the rental total of a product with advanced pricing enabled
 *
 * @param float $total The calculated total of the product
 * @param array $data The advanced pricing data for the product
 *
 * @return float The modified total
 */
function kwp_rentals_advanced_pricing_add_extra_amount_to_rental_total( $total, $data ) {

    // This will effect all rentals, you may wish to add a condition here based on $data to target specific products, categories, etc

    $total = $total + ( 5.00 * (int) $data['quantity'] ); // Add $5 multiplied by the quantity to the calculated total 
    //$total = $total + 5.00; // Add additional $5 to the calculated total without multiplying by the quantity, if uncommenting this line, ensure the line above is removed

    return $total;
}
add_filter( 'wcrp_rental_products_advanced_pricing', 'kwp_rentals_advanced_pricing_add_extra_amount_to_rental_total', 10, 2 );