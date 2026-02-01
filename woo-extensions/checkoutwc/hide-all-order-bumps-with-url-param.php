<?php // Only copy this line if needed!

/**
 * Hide all Order Bumps when ?bumps=0 or ?bumps=none is added to the checkout URL.
 * 
 * Useful for troubleshooting checkout issues without bump interference,
 * or for sending customers a "clean" checkout link for testing.
 * 
 * Example: https://yoursite.com/checkout?bumps=none
 */

add_action( 'wp_footer', function() {
    if ( isset( $_GET['bumps'] ) && in_array( $_GET['bumps'], [ '0', 'none' ], true ) ) {
        ?>
        <script>
        document.addEventListener( 'DOMContentLoaded', function() {
            document.querySelectorAll( '[id^="cfw_bumps_"]' ).forEach( function( el ) {
                el.style.display = 'none';
            });
            console.log( 'All bumps hidden by ?bumps parameter' );
        });
        
        const observer = new MutationObserver( function( mutations ) {
            mutations.forEach( function( mutation ) {
                if ( mutation.type === 'childList' ) {
                    mutation.addedNodes.forEach( function( node ) {
                        if ( node.id && node.id.startsWith( 'cfw_bumps_' ) ) {
                            node.style.display = 'none';
                        }
                    });
                }
            });
        });
        
        observer.observe( document.body, { childList: true, subtree: true } );
        </script>
        <?php
    }
});