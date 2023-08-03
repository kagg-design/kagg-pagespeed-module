<?php
/**
 * PageSpeed Module
 *
 * @package              kagg-pagespeed-module
 * @author               KAGG Design
 * @license              GPL-2.0-or-later
 * @wordpress-plugin
 *
 * Plugin Name:          PageSpeed Module
 * Plugin URI:           https://wordpress.org/plugins/kagg-pagespeed-module/
 * Description:          Support of PageSpeed Module for Apache or Nginx.
 * Version:              2.0
 * Requires at least:    4.4
 * Requires PHP:         7.0
 * Author:               KAGG Design
 * Author URI:           https://kagg.eu/en/
 * License:              GPL v2 or later
 * License URI:          https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:          kagg-pagespeed-module
 * Domain Path:          /languages/
 */

use KAGG\PagespeedModule\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( defined( 'MOD_PAGESPEED_VERSION' ) ) {
	return;
}

/**
 * Plugin version.
 */
const MOD_PAGESPEED_VERSION = '2.0';

/**
 * Path to the plugin dir.
 */
const MOD_PAGESPEED_PATH = __DIR__;

/**
 * Plugin dir url.
 */
define( 'MOD_PAGESPEED_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Main plugin file.
 */
const MOD_PAGESPEED_FILE = __FILE__;

require_once MOD_PAGESPEED_PATH . '/vendor/autoload.php';

/**
 * Get main class instance.
 *
 * @return Main
 */
function kagg_pagespeed_module() {
	static $mod_pagespeed;

	if ( ! $mod_pagespeed ) {
		$mod_pagespeed = new Main();
	}
	return $mod_pagespeed;
}

kagg_pagespeed_module()->init();
