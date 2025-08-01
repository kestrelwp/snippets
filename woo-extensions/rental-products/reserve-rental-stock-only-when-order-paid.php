<?php // only copy if needed!

/*
Return false to only reserve rental stock once an order is a paid status, rental order management workflows differ when used.
Be careful if you activate this filter hook, then decide to disable it later. If you currently have unreserved rentals, those rentals will look like they are reserved when the filter hook is removed, even though they aren’t.
*/
add_filter( 'wcrp_rental_products_reserve_stock_for_unpaid_orders', '__return_false' );