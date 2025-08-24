<?php // only copy if needed!

/*
 * WCLSI – Debug: New Lightspeed products not importing to Woo
 *
 * WHAT THIS DOES
 * - Logs basic details for each LS item the poller sees, so you can confirm if
 *   LS is writing an older `createTime` than the `update` timestamp on new items.
 *
 * SETUP
 * 1) Drop this snippet into a small plugin or mu-plugin.
 * 2) Create a NEW product in Lightspeed.
 * 3) Wait for the `wclsi_poll` background job to run (or select to "Run" from the Pending Action Scheduler Queue).
 * 4) Check your wclsi-errors-log for entries containing: "unimported product".
 *
 * HOW TO INTERPRET
 * - Compare the "create time" vs the "update timestamp" for your NEW product.
 * - If `createTime` is significantly newer than the `update` time (e.g., hours),
 *   the default look-back window (default ~60s) will miss it.
 *
 * - Fix: Increase the look-back window using the filter below
 *   to at least (update - create) + 60 seconds, then test again.
 *
 * NEED HELP?
 * - Email support@kestrelwp.com and include a copy/paste of the log lines.
 */

function view_unimported_items ( $ls_api_item ) {

	WCLSI_Logger::log_error( 'unimported product description: ', $ls_api_item->description );
	WCLSI_Logger::log_error( 'unimported product create time: ', $ls_api_item->createTime );
	WCLSI_Logger::log_error( 'unimported product update timestamp: ', $ls_api_item->timeStamp );
	WCLSI_Logger::log_error( 'ls_api_item: ', $ls_api_item );

};

add_action( 'wclsi_poller_update', 'view_unimported_items', 10, 2 );

/*
 * WCLSI – Adjust poller look-back window (in seconds)
 *
 * WHEN TO USE
 * - Only if your logs show a NEW item where `update` time is much newer than `createTime`.
 *
 * HOW TO SET
 * - Compute (update - create) in seconds, then add a small buffer (e.g., +60).
 * - Replace "$default" by returning that number.
 *
 * EXAMPLE
 * - New item shows createTime 10:00:00 and update 12:00:00 (delta = 7200).
 * - Return 7260 to catch those items during polling:
 *     return 7260;
 *
 */

function change_lookback_time( $default ) {

	// Return a larger window ONLY if your logs show a big delta.
	// Example:
	// return 7260;

	return $default;
}

add_filter( 'wclsi_get_look_back_time', 'change_lookback_time', 10, 2 );
