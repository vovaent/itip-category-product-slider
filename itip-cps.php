<?php
/**
 * Plugin Name:       ITIP Category Product Slider
 * Description:       Plugin for displaying product images as a slider on product cards in categories.
 * Requires at least: 6.4
 * Requires PHP:      8.2
 * Version:           0.1.0
 * Author:            Volodymyr Voitovych
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package           Itip_Category_Product_Slider
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

const WOO_PLUGIN_NAME  = 'woocommerce/woocommerce.php';
const THIS_PLUGIN_NAME = 'itip-category-product-slider/itip-cps.php';

define( 'BUTTON', '<a href="%s" rel="nofollow ugc">' . __( 'Return to Plugins', 'itip-category-product-slider' ) . '</a>' );
define( 'ERROR_MESSAGE', __( 'The ITIP Category Slider plugin is deactivated because it requires the Woocommerce plugin to be installed and activated!', 'itip-category-product-slider' ) );

// Check if needed functions exists - if not, require them.
if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * Checks that the plugin is installed.
 *
 * @param string $plugin_name Plugin name.
 *
 * @return bool
 */
function itip_cps__is_plugin_installed( string $plugin_name ): bool {
	$installed_plugins = get_plugins();

	return array_key_exists( $plugin_name, $installed_plugins );
}

/**
 * Checks that the plugin is activated.
 *
 * @param string $plugin_name Plugin name.
 *
 * @return bool
 */
function itip_cps__is_plugin_activated( string $plugin_name ): bool {
	if ( is_plugin_active( $plugin_name ) ) {
		return true;
	}

	return false;
}

/**
 * Checks that the plugin is installed and activated.
 *
 * @param string $plugin_name Plugin name.
 *
 * @return bool
 */
function itip_cps__is_plugin_installed_and_activated( string $plugin_name ): bool {
	$is_acf_installed = itip_cps__is_plugin_installed( $plugin_name );
	$is_acf_activated = itip_cps__is_plugin_activated( $plugin_name );

	return $is_acf_installed && $is_acf_activated;
}

/**
 * Checks that the Woocommerce plugin is installed and activated.
 */
function itip_cps__this_plugin_init_or_deactivate(): void {
	$is_woo_installed_and_activated = itip_cps__is_plugin_installed_and_activated( WOO_PLUGIN_NAME );

	if ( $is_woo_installed_and_activated ) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/plugin-functions.php';
	} else {
		deactivate_plugins( THIS_PLUGIN_NAME );
	}
}

register_activation_hook( __FILE__, 'itip_cps__this_plugin_init_or_deactivate' );
add_action( 'wp_loaded', 'itip_cps__this_plugin_init_or_deactivate' );

/**
 * Prints an error message on the admin screen
 * if the Woocommerce plugin is not installed and/or activated.
 *
 * @return void
 */
function itip_cps__add_error_message_to_admin_panel(): void {
	$is_woo_installed_and_activated = itip_cps__is_plugin_installed_and_activated( WOO_PLUGIN_NAME );

	if ( ! $is_woo_installed_and_activated ) {
		$err_msg = ERROR_MESSAGE;

		global $pagenow;

		if ( 'plugins.php' !== $pagenow ) {
			$err_msg .= ' ' . sprintf( BUTTON, esc_attr( network_admin_url( 'plugins.php' ) ) );
		}

		echo '<div class="notice notice-warning is-dismissible">
            	 <p>' . wp_kses_post( $err_msg ) . '</p>
         	</div> ';
	}
}

add_action( 'admin_notices', 'itip_cps__add_error_message_to_admin_panel' );
