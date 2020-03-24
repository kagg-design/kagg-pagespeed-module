<?php
/**
 * Plugin Name: PageSpeed Module
 * Plugin URI:
 * Description: Support of PageSpeed Module for Apache or Nginx.
 * Author: KAGG Design
 * Author URI: https://kagg.eu/en/
 * Requires at least: 4.4
 * Tested up to: 5.4
 * Version: 1.1.6
 * Stable tag: 1.1.6
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

if ( defined( 'MOD_PAGESPEED_VERSION' ) ) {
	return;
}

/**
 * Plugin version.
 */
define( 'MOD_PAGESPEED_VERSION', '1.1.6' );

/**
 * Path to the plugin dir.
 */
define( 'MOD_PAGESPEED_PATH', dirname( __FILE__ ) );

/**
 * Plugin dir url.
 */
define( 'MOD_PAGESPEED_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Main plugin file.
 */
define( 'MOD_PAGESPEED_FILE', __FILE__ );

/**
 * Init PageSpeed Module class on plugin load.
 */
function init_mod_pagespeed_class() {
	require_once MOD_PAGESPEED_PATH . '/vendor/autoload.php';
	new Mod_PageSpeed();
}

add_action( 'plugins_loaded', 'init_mod_pagespeed_class' );
