<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class Mod_PageSpeed.
 *
 * @class Mod_PageSpeed
 * version 1.1.1
 */
class Mod_PageSpeed {

	/**
	 * @var string Plugin version.
	 */
	public $version;

	/**
	 * @var string Absolute plugin path.
	 */
	public $plugin_path;

	/**
	 * @var string Absolute plugin URL.
	 */
	public $plugin_url;

	/**
	 * @var array Plugin options.
	 */
	private $options;

	/**
	 * Mod_PageSpeed constructor.
	 */
	public function __construct() {
		// Init fields.
		$this->version = '1.1.1';
		$this->plugin_path = trailingslashit( plugin_dir_path( __DIR__ ) );
		$this->plugin_url    = trailingslashit( plugin_dir_url( __DIR__ ) );
		$this->options = get_option( 'mod_pagespeed_settings' );

		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( MOD_PAGESPEED_PLUGIN_FILE ), array( $this, 'add_settings_link' ), 10, 2 );
		add_action( 'admin_init', array( $this, 'setup_fields' ) );

		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 100 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_ajax_mod_pagespeed', array( $this, 'ajax_action' ) );
		add_action( 'init', array( $this, 'mod_pagespeed_arg' ) );
		add_action( 'admin_init', array( $this, 'mod_pagespeed_arg' ) );
}

	/**
	 * Add settings page to the menu.
	 */
	public function add_settings_page() {
		$page_title = __( 'PageSpeed', 'kagg-pagespeed-module' );
		$menu_title = __( 'PageSpeed', 'kagg-pagespeed-module' );
		$capability = 'manage_options';
		$slug       = 'mod-pagespeed';
		$callback   = array( $this, 'mod_pagespeed_settings_page' );
		$icon       = $this->plugin_url . 'images/icon-16x16.png';
		$icon       = '<img class="ps-menu-image" src="' . $icon . '">';
		$menu_title = $icon . '<span class="ps-menu-title">' . $menu_title . '</span>';
		add_options_page( $page_title, $menu_title, $capability, $slug, $callback );
	}

	/**
	 * Options page.
	 */
	public function mod_pagespeed_settings_page() {
		?>
		<div class="wrap">
			<h2 id="title">
				<?php
				// Admin panel title.
				echo( esc_html( __( 'PageSpeed Plugin Options', 'kagg-pagespeed-module' ) ) );
				?>
			</h2>

			<form action="options.php" method="POST">
				<?php
				settings_fields( 'mod_pagespeed_group' ); // Hidden protection fields.
				do_settings_sections( 'mod-pagespeed' ); // Sections with options.
				// submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Setup options fields.
	 */
	public function setup_fields() {
		add_settings_section( 'purge_section', __( 'Purge Cache', 'kagg-pagespeed-module' ),
			array( $this, 'mod_pagespeed_purge_section' ), 'mod-pagespeed'
		);
		add_settings_section( 'development_section', __( 'Development Mode', 'kagg-pagespeed-module' ),
			array( $this, 'mod_pagespeed_development_section' ), 'mod-pagespeed'
		);
	}

	/**
	 * Purge Cache section.
	 */
	public function mod_pagespeed_purge_section() {
		$title       = __( 'Purge Styles', 'kagg-pagespeed-module' );
		$text        = __( 'Clear cached version of current WordPress theme style.css file.<br><br>This is useful when styles were changed.', 'kagg-pagespeed-module' );
		$button_text = __( 'Purge Styles', 'kagg-pagespeed-module' );
		$this->card_section( $title, $text, $button_text, 'purge_styles' );

		$title       = __( 'Purge Entire Cache', 'kagg-pagespeed-module' );
		$text        = __( 'Clear entire PageSpeed cache on site. This action fetches fresh versions of all pages, images, and scripts on your web site.<br><br>Please note that PageSpeed module will take some time to re-create cache after several page visits.', 'kagg-pagespeed-module' );
		$button_text = __( 'Purge Entire Cache', 'kagg-pagespeed-module' );
		$this->card_section( $title, $text, $button_text, 'purge_entire_cache' );
	}

	/**
	 * Output card option section
	 *
	 * @param string $title Card title
	 * @param string $text Card text
	 * @param string $button_text Button text
	 * @param string $button_id Button id
	 */
	private function card_section( $title, $text, $button_text, $button_id ) {
		?>
		<section class="ps-card">
			<div class="ps-card-section">
				<div class="ps-card-content">
					<h3 class="ps-card-title"><?php echo esc_html( $title ); ?></h3>
					<p><?php echo wp_kses_post( wpautop( $text ) ); ?></p>
				</div>
				<div class="ps-card-control">
					<button id="<?php echo esc_attr( $button_id ); ?>" type="button" class="ps-btn">
						<?php echo esc_html( $button_text ); ?>
					</button>
				</div>
			</div>
		</section>
		<?php
	}

	/**
	 * Development Mode section.
	 */
	public function mod_pagespeed_development_section() {
		$title   = __( 'Development Mode', 'kagg-pagespeed-module' );
		$text    = __( 'When development mode is on, all PageSpeed cache is bypassed.<br><br>This is done by adding ?ModPagespeed=off agrument to every site url.', 'kagg-pagespeed-module' );
		$dev_mode = $this->options['dev_mode'];
		if ( 'true' === $dev_mode ) {
			$active = 'active';
			$checked = 'checked=checked';
		} else {
			$active = '';
			$checked = '';
		}
		?>
		<section class="ps-card">
			<div class="ps-card-section">
				<div class="ps-card-content">
					<h3 class="ps-card-title"><?php echo esc_html( $title ); ?></h3>
					<p><?php echo wp_kses_post( wpautop( $text ) ); ?></p>
				</div>
				<div class="ps-card-control">
					<label class="ps-toggle <?php echo esc_attr( $active ); ?>">
						<input id="dev_mode" type="checkbox" <?php echo esc_attr( $checked ); ?> class="ps-checkbox">
					</label>
				</div>
			</div>
		</section>
		<?php
		echo '<div id="ps-success"></div>';
		echo '<div id="ps-error"></div>';
	}

	/**
	 * Load plugin text domain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'kagg-pagespeed-module', false,
			plugin_basename( $this->plugin_path ) . '/languages/'
		);
	}

	/**
	 * Enqueue plugin scripts.
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_script( 'mod-pagespeed-admin', $this->plugin_url . 'js/mod-pagespeed-admin.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( 'mod-pagespeed-admin', 'mod_pagespeed', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'mod-pagespeed-nonce' ),
		) );
		wp_enqueue_style( 'mod-pagespeed-admin',  $this->plugin_url . 'css/mod-pagespeed-admin.css', array(), $this->version );
	}

	/**
	 * Process ajax request.
	 */
	public function ajax_action() {
		if ( ! wp_verify_nonce( $_POST['nonce'], 'mod-pagespeed-nonce' ) ) {
			wp_send_json_error( __( 'Bad nonce!', 'kagg-pagespeed-module' ) );
		}

		$id = sanitize_html_class( $_POST['id'] );

		switch ( $id ) {
			case 'purge_styles':
				$link = get_stylesheet_uri();
				$this->purge_link( $link );
				break;
			case 'purge_entire_cache':
				$link = site_url() . '/*.*';
				$this->purge_link( $link );
				break;
			case 'dev_mode':
				$checked = sanitize_text_field( $_POST['checked'] );
				$this->options['dev_mode'] = $checked;
				if ( 'true' === $checked ) {
					$mode = __( 'Development mode is on', 'kagg-pagespeed-module' );
				} else {
					$mode = __( 'Development mode is off', 'kagg-pagespeed-module' );
				}
				update_option( 'mod_pagespeed_settings', $this->options );
				wp_send_json_success( $mode );
				break;
			default:
				wp_send_json_error( __( 'Unknown error', 'kagg-pagespeed-module' ) );
		}
	}

	/**
	 * Purge cache for $link
	 *
	 * @param string $link a link to file or * to be purged
	 */
	private function purge_link( $link ) {
		$result = wp_remote_head( site_url() . '/*.*', array(
			'redirection' => 0,
		) );
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( $result->get_error_message() . ' - ' . $link );
		}

		$x_page_speed = wp_remote_retrieve_header( $result, 'x-page-speed' );
		if ( '' === $x_page_speed ) {
			wp_send_json_error( __( 'PageSpeed Module is not installed on your server. Plugin is useless.', 'kagg-pagespeed-module' ) );
		}

		$cf = false;
		$server_ip = '';
		$server = wp_remote_retrieve_header( $result, 'server' );
		if ( false !== strpos( $server, 'cloudflare' ) ) {
			// Site is behind Cloudflare.
			$cf = true;
			$server_ip = $_SERVER['SERVER_ADDR'];
		}

		// Normal request looks like: curl -X PURGE -L 'http://domain.org/*.*'
		// Request for Cloudflare looks like: curl -X PURGE -H 'host: domain.org' -L -k $server_ip/*.*
		$url = $link;
		$args = array(
			'method'      => 'PURGE',
			'redirection' => 0,
		);
		if ( $cf ) {
			$link_array = wp_parse_url( $link );
			$url = $link_array['scheme'] . '://' . $server_ip . $link_array['path'];
			$args['redirection'] = 5; // -L
			$args['sslverify'] = false; // -k
			$args['headers'] = 'host: ' . $link_array['host'];
		};

		$result = wp_remote_request( $url, $args );
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( $result->get_error_message() . ' - ' . $link );
		}
		if ( 200 === $result['response']['code'] ) {
			wp_send_json_success( esc_html( wp_remote_retrieve_body( $result ) ) . ' - ' . $link );
		} else {
			wp_send_json_error( wp_remote_retrieve_response_message( $result ) . ' - ' . $link );
		}

	}

	/**
	 * For any site url, add or remove ?ModPagespeed argument
	 */
	public function mod_pagespeed_arg() {
		if ( wp_doing_ajax() ) {
			return;
		}
		$dev_mode = $this->options['dev_mode'];

		// @codingStandardsIgnoreStart
		// It is impossible to set nonce for any WordPress url.
		isset( $_REQUEST['ModPagespeed'] ) ? $mod_pagespeed = $_REQUEST['ModPagespeed'] : $mod_pagespeed = '';
		// @codingStandardsIgnoreEnd

		if ( $mod_pagespeed ) {
			if ( ( 'off' === $mod_pagespeed ) && ( 'true' === $dev_mode ) ) {
				return;
			} else {
				$url = remove_query_arg( 'ModPagespeed' );
				wp_redirect( $url , 301 );
			}
		}
		if ( 'true' === $dev_mode ) {
			$url = add_query_arg( array(
				'ModPagespeed' => 'off',
			) );
			wp_redirect( $url , 301 );
		}
	}

	/**
	 * Add link to plugin setting page on plugins page.
	 *
	 * @param array $links Plugin links
	 *
	 * @return array|mixed Plugin links
	 */
	public function add_settings_link( $links, $file ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'options-general.php?page=mod-pagespeed' ) . '" aria-label="' . esc_attr__( 'View PageSpeed Module settings', 'kagg-pagespeed-module' ) . '">' . esc_html__( 'Settings', 'kagg-pagespeed-module' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}
}
