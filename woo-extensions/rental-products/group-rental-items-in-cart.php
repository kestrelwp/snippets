<?php // only copy if needed!

// Groups rental items together in cart, ordered by rental date
add_filter( 'wcrp_rental_products_cart_group_rentals', '__return_true' );