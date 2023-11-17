<?php

namespace HtmxPress\Template;

use const HtmxPress\Endpoint\HTMX_ENDPOINT;

function bootstrap() {
	add_action( 'template_redirect', __NAMESPACE__ . '\\render' );
}

function render() {
	global $wp_query;
	if ( ! isset( $wp_query->query_vars[ HTMX_ENDPOINT ] ) ) {
		return;
	}

	// POST nonce protection
	if ( $_SERVER["REQUEST_METHOD"] === 'POST' && ! is_nonced() ) {
		return;
	}
	$template_name = get_template_name();
	load_template_or_404( $template_name );
	exit;
}

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
	return ! ! wp_verify_nonce( $nonce, 'htmx' );
}

function get_template_name() : string {
	$template_name = 'root';
	$query_var = get_query_var( HTMX_ENDPOINT );
	if ( ! empty( $query_var ) ) {
		$template_name = sanitize_file_name( $query_var );
	}

	return $template_name;
}

function load_template_or_404( string $template_name ) : void {
	// Allow adding to the template paths, with the included demo ones as a fallback.
	$paths = apply_filters( 'htmx.template_paths', [] );
	if (empty($paths)) {
		$paths[] = dirname( __FILE__, 2 ) . "/templates/";
	}
	array_walk( $paths, static function ( &$path ) {
		$path = trailingslashit( $path );
	} );

	$match = false;
	// match one path
	foreach ( $paths as $path ) {
		$path = "$path${template_name}.php";
		if ( file_exists( $path ) ) {
			$match = true;
			$is_partial = str_starts_with( $template_name, 'partial-' );
			if ( $is_partial ) {
				include $path;
				break;
			}
			load_template( $path );
			break;
		}
	}

	global $wp_query;
	if ( ! $match ) {
		$wp_query->set_404();
		status_header( 404 );
	}
}
