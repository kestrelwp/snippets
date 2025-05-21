<?php

/**
 * The plugin comes with a built-in debug mode that can be enabled in the plugin settings.
 *
 * This will produce log data in WooCommerce > Status > Logs that may be helpful for troubleshooting.
 *
 * However, there are cases where additional data from AWS S3 may be needed for debugging when complicated issues arise.
 * Use the snippet below to enable the S3 client debug mode.
 *
 * WARNING: This will generate a lot of additional log data, so it should only be used temporarily for debugging purposes.
 */

add_filter( 'woocommerce_amazon_s3_client_debug_mode', '__return_true' );