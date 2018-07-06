<?php
/**
 * Plugin Name: PageSpeed Module
 * Plugin URI:
 * Description: Support of PageSpeed Module for Apache or Nginx.
 * Author: KAGG Design
 * Version: 1.1.1
 * Author URI: https://kagg.eu/en/
 * Requires at least: 4.4
 * Tested up to: 4.9
 *
 * Text Domain: kagg-pagespeed-module
 * Domain Path: /languages/
 *
 * @package PageSpeed Module
 * @author KAGG Design
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WC_PLUGIN_FILE.
if ( ! defined( 'MOD_PAGESPEED_PLUGIN_FILE' ) ) {
	define( 'MOD_PAGESPEED_PLUGIN_FILE', __FILE__ );
}

/**
 * Init PageSpeed Module class on plugin load.
 */

function init_mod_pagespeed_class() {
	static $plugin;

	if ( ! isset( $plugin ) ) {
		// Require main class of the plugin.
		require_once( dirname( __FILE__ ) . '/includes/class-mod-pagespeed.php' );

		$plugin = new Mod_PageSpeed();
	}
}

add_action( 'plugins_loaded', 'init_mod_pagespeed_class' );
