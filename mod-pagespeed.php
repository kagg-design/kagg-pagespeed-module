<?php
/**
 * Plugin Name: PageSpeed Module
 * Plugin URI:
 * Description: Support of PageSpeed Module for Apache or Nginx.
 * Author: KAGG Design
 * Author URI: https://kagg.eu/en/
 * Requires at least: 4.4
 * Tested up to: 5.3
 * Version: 1.1.5
 * Stable tag: 1.1.5
 *
 * Text Domain: kagg-pagespeed-module
 * Domain Path: /languages/
 *
 * @package kagg-pagespeed-module
 * @author  KAGG Design
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'MOD_PAGESPEED_PATH' ) ) {
	/**
	 * Path to the plugin dir.
	 */
	define( 'MOD_PAGESPEED_PATH', dirname( __FILE__ ) );
}

if ( ! defined( 'MOD_PAGESPEED_URL' ) ) {
	/**
	 * Plugin dir url.
	 */
	define( 'MOD_PAGESPEED_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
}

if ( ! defined( 'MOD_PAGESPEED_FILE' ) ) {
	/**
	 * Main plugin file.
	 */
	define( 'MOD_PAGESPEED_FILE', __FILE__ );
}

if ( ! defined( 'MOD_PAGESPEED_VERSION' ) ) {
	/**
	 * Plugin version.
	 */
	define( 'MOD_PAGESPEED_VERSION', '1.1.5' );
}

/**
 * Init PageSpeed Module class on plugin load.
 */
function init_mod_pagespeed_class() {
	static $plugin;

	if ( ! isset( $plugin ) ) {
		require_once MOD_PAGESPEED_PATH . '/vendor/autoload.php';
		$plugin = new Mod_PageSpeed();
	}
}

add_action( 'plugins_loaded', 'init_mod_pagespeed_class' );
