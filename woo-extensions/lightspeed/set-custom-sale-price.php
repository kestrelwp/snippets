<?php // only copy if needed!

/**
 * Set a custom Sale Price from a Lightspeed tier if it beats Woo's sale price.
 *
 * @param float|string $sale_price      Current Woo sale price (may be '' or '0' if none).
 * @param object       $wclsi_product   Exposes manufacturer_id and get_item_prices().
 * @return float|string
 */

function set_custom_sale_price ( $sale_price, $wclsi_product ) {
	global $wpdb, $WCLSI_ITEM_TABLE, $WCLSI_ITEM_PRICES_TABLE, $WCLSI_Lightspeed_Prod;

	//this is the tier name from Lightspeed. It is case sensitive.
	$custom_tier_name = "Exclusive K9";

	//custom criteria to meet to apply this pricing
	//For example: Only apply the custom tier pricing based on the LS manufacturer

	//	$manufacturer_id_array = [6];
	//	$product_manufacturer = $wclsi_product->manufacturer_id;
	//
	//	if ( ! in_array( $product_manufacturer, $manufacturer_id_array ) ) {
	//		return $sale_price;
	//	}

	//iterate through item prices for the product and set the custom tier price if it is lower than the sale price
	$item_prices = $wclsi_product->get_item_prices();
	if ( $item_prices ) {
		$custom_tier_price = 0;

		foreach ( $item_prices as $price ) {
			if ( $price->use_type === $custom_tier_name ) {
				$custom_tier_price = $price->amount;
			}
		}

		// use the lower of the sale price and custom price
		if ( $custom_tier_price > 0 && $custom_tier_price < $sale_price ) {
			$sale_price = $custom_tier_price;
		}

	}

	return $sale_price;

};

add_action( 'wclsi_get_sale_price', 'set_custom_sale_price', 10, 3 );