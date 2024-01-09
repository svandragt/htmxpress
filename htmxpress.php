<?php //phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

/**
 * Plugin Name:  HTMXpress
 * Plugin URI:   https://vandragt.com
 * Description:  HTMX for WordPress
 * Version:      0.1
 * Author:       Sander van Dragt <sander@vandragt.com>
 * Author URI:   https://vandragt.com
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  htmxpress
 * Domain Path:  /languages
 */

namespace HtmxPress;

require_once( __DIR__ . '/inc/assets.php' );
require_once( __DIR__ . '/inc/endpoint.php' );
require_once( __DIR__ . '/inc/template.php' );

/**
 * Activate the plugin.
 *
 * @return void
 */
function activate() : void {
	Endpoint\register();
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate' );

/**
 * Deactivate the plugin.
 *
 * @return void
 */
function deactivate() : void {
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate' );

/**
 * Bootstrap the plugin.
 *
 * @return void
 */
function bootstrap() : void {
	Endpoint\register();
	Template\bootstrap();
	Assets\bootstrap();
}

add_action( 'init', __NAMESPACE__ . '\\bootstrap' );
