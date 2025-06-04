<?php //phpcs:ignore PSR1.Files.SideEffects.FoundWithSymbols

/**
 * Plugin Name:  HTMXpress
 * Plugin URI:   https://vandragt.com
 * Description:  HTMX for WordPress
 * Version:      0.1.1
 * Author:       Sander van Dragt <sander@vandragt.com>
 * Author URI:   https://vandragt.com
 * License:      GPL3
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:  htmxpress
 * Domain Path:  /languages
 */

namespace HtmxPress;

const OPTION_REWRITE_RULES = 'htmxpress_rewrite_rules';
const OPTION_REWRITE_RULES_VERSION = '20250604';

require_once( __DIR__ . '/inc/assets.php' );
require_once( __DIR__ . '/inc/endpoint.php' );
require_once( __DIR__ . '/inc/template.php' );

/**
 * Deactivate the plugin.
 *
 * @return void
 */
function deactivate() : void {
	delete_option( OPTION_REWRITE_RULES );
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
	if ( update_option( OPTION_REWRITE_RULES, OPTION_REWRITE_RULES_VERSION ) ) {
		flush_rewrite_rules();
	}

	Template\bootstrap();
	Assets\bootstrap();
}

add_action( 'init', __NAMESPACE__ . '\\bootstrap' );
