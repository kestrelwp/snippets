<?php

/**
 * Since v3.0.5, Amazon S3 Storage for WooCommerce provides experimental support for alternative cloud storage platforms.
 * These platforms need to be compatible with the AWS S3 API, such as Cloudflare R2, Backblaze B2, DigitalOcean Spaces, Wasabi, etc.
 *
 * The following snippet is for Cloudflare R2, based on https://developers.cloudflare.com/r2/examples/aws/aws-sdk-php/
 * However, it should work consistently with other providers (the endpoint URL value will differ significantly).
 * For Backblaze B2, see https://www.backblaze.com/docs/cloud-storage-use-the-aws-sdk-for-php-with-backblaze-b2.
 * Other providers may have similar documentation, contact their support to share information on their S3 compatibility.
 *
 * Since the regions in these platforms may not be the same as AWS, it may be necessary to specify region and bucket in shorcodes.
 *
 * NOTE: Replace strings between angle brackets "<...>" with your own values.
 */

// list of allowed values: 'cloudflare', 'backblaze', 'digitalocean', 'wasabi', 'aws' (default)
add_filter( 'woocommerce_amazon_s3_client_cloud_service', fn() => 'cloudflare' );

add_filter( 'woocommerce_amazon_s3_client_args', function( $args ) {
    return array_merge( $args, [
        'region'      => 'auto',
        'endpoint'    => 'https://<insert your cloudflare account ID here>.r2.cloudflarestorage.com',
        'credentials' => [
            'key'    => '<insert your cloudflare key here>',
            'secret' => '<insert your cloudflare secret here>'
        ],
    ] );
} );

// uncomment the following for additional troubleshooting if enabling debug mode in plugin settings isn't helpful (NOTE: may generate large log files)
// add_filter( 'woocommerce_amazon_s3_client_debug_mode', '__return_true' );