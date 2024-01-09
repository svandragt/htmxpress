<?php
/**
 * Templating functions.
 */

namespace HtmxPress\Template;

use const HtmxPress\Endpoint\HTMX_ENDPOINT;

/**
 * Bootstrap.
 *
 * @return void
 */
function bootstrap() : void {
	add_action( 'template_redirect', __NAMESPACE__ . '\\render' );
}

/**
 * Render a template.
 *
 * @return void
 */
function render() : void {
	global $wp_query;
	if ( ! isset( $wp_query->query_vars[ HTMX_ENDPOINT ] ) ) {
		return;
	}

	// POST nonce protection
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! is_nonced() ) {
		return;
	}
	$template_name = get_template_name();
	$template_loaded = load_htmx_template( $template_name );
	maybe_set_404( $template_loaded );
	exit;
}

/**
 * Set 404 status if the template wasn't loaded.
 *
 * @param bool $template_loaded Whether a template was loaded.
 *
 * @return void
 */
function maybe_set_404( bool $template_loaded ) : void {
	global $wp_query;
	if ( ! $template_loaded ) {
		$wp_query->set_404();
		status_header( 404 );
	}
}

/**
 * Check if the request is nonced.
 *
 * @return bool
 */
function is_nonced() : bool {
	$nonce = null;

	if ( isset( $_REQUEST['_wpnonce'] ) ) {
		$nonce = $_REQUEST['_wpnonce'];
	} elseif ( isset( $_SERVER['HTTP_X_WP_NONCE'] ) ) {
		$nonce = $_SERVER['HTTP_X_WP_NONCE'];
	}

	if ( null === $nonce ) {
		// No nonce at all, so act as if it's an unauthenticated request.
		wp_set_current_user( 0 );

		return false;
	}

	// Check the nonce is not false.
	return (bool) wp_verify_nonce( $nonce, 'htmx' );
}

/**
 * Get the template name. Defaults to 'root' if no query var is set.
 *
 * @return string
 */
function get_template_name() : string {
	$template_name = 'root';
	$query_var = get_query_var( HTMX_ENDPOINT );
	if ( ! empty( $query_var ) ) {
		$template_name = sanitize_file_name( $query_var );
	}

	return $template_name;
}

/**
 * Load a template or return 404 if it's not found. This is a copy of the WordPress `load_template` function, but with
 * 404 handling.
 *
 * @param string $template_name Name of the template to load.
 *
 * @return bool Whether a template was loaded
 */
function load_htmx_template( string $template_name ) : bool {
	// Allow adding to the template paths.
	// phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores -- Established filter.
	$paths = apply_filters( 'htmx.template_paths', [] );
	array_walk( $paths, static function ( &$path ) {
		$path = trailingslashit( $path );
	} );

	// walk through the paths to find the first matching template.
	$template_loaded = false;
	foreach ( $paths as $path ) {
		$path = "$path${template_name}.php";
		if ( file_exists( $path ) ) {
			$template_loaded = true;
			load_template( $path );
			break;
		}
	}

	return $template_loaded;
}
