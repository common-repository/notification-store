<?php
/*
Plugin Name: Notification Store
Description: Store your notifications to display it on frontend
Plugin URI: https://notification.underdev.it
Author: HugoPoi
Author URI: https://blog.hugopoi.net/
Version: 1.0
License: GPL3
Text Domain: notification-store
Domain Path: /languages
*/

/**
 * Composer autoload
 */
require_once( 'vendor/autoload.php' );

/**
 * Setup plugin
 * @return void
 */
function notification_store_plugin_setup() {

	load_plugin_textdomain( 'notification-store', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

}
add_action( 'plugins_loaded', 'notification_store_plugin_setup' );

/**
 * Initialize plugin
 * @return void
 */
function notification_store_settings_initialize() {

	/**
	 * Settings instance
	 */
	new HugoPoi\Notification\Store\Settings();

}
add_action( 'init', 'notification_store_settings_initialize', 5 );

/**
 * Initialize plugin
 * @return void
 */
function notifications_store_initialize() {

	/**
   * Init NotificationsStore service
	 */
  HugoPoi\Notification\Store\NotificationsStore::get();
  new HugoPoi\Notification\Store\RegisterAcf();

}
add_action( 'init', 'notifications_store_initialize', 10 );

/**
 * Do some check on plugin activation
 * @return void
 */
function notification_store_activation() {

	if ( version_compare( PHP_VERSION, '5.3', '<' ) || ! is_plugin_active( 'notification/notification.php' ) || ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {

		deactivate_plugins( plugin_basename( __FILE__ ) );

		wp_die( __( 'This plugin requires PHP in version at least 5.3, Notification and Advanced Custom Fields plugins active. WordPress itself <a href="https://wordpress.org/about/requirements/" target="_blank">requires at least PHP 5.6</a>. Please upgrade your PHP version or contact your Server administrator.', 'notification-store' ) );

	}

}
register_activation_hook( __FILE__, 'notification_store_activation' );
