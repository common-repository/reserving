<?php
/**
 * Reserving Uninstall
 * Uninstalling reserving deletes user roles, pages, tables, and options.
 * @package reserving\Uninstaller
 * @version 1.0
 */
defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

global $wpdb, $wp_version;

/*
 * Only remove options and page data if this plugin constant is set to true in user's
 * wp-config.php. This is to prevent data loss when deleting the plugin from the backend
 * and to ensure only the site owner can perform this action.
 */
if ( defined( 'RESERVING_REMOVE_ALL_DATA' ) ){ 

	// Clear any cached data that has been removed.
	wp_cache_flush();
}
