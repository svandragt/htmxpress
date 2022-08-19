<?php

namespace HTMXPress\Template;

use const HTMXpress\Endpoint\HTMX_ENDPOINT;

function bootstrap() {
	add_action( 'template_redirect', __NAMESPACE__ . '\\render' );
}

function render() {
	global $wp_query;
	if ( ! isset( $wp_query->query_vars[ HTMX_ENDPOINT ] ) ) {
		return;
	}

	// POST nonce protection
	if ( $_SERVER["REQUEST_METHOD"] === 'POST' && ! wp_verify_nonce( $_SERVER["X_WP_NONCE"], 'htmx' ) ) {
		// die( 'security nope' );
		return;
	}
	$template_name = get_template_name();
	load_template_or_404( $template_name );
	exit;
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
	$path = trailingslashit( apply_filters( 'htmx.template_path', dirname( __FILE__, 2 ) . "/templates/" ) );
	$path = "$path${template_name}.php";
	global $wp_query;
	if ( ! file_exists( $path ) ) {
		$wp_query->set_404();
		status_header( 404 );

		return;
	} else {
		$is_partial = str_starts_with( $template_name, 'partial-' );
		if ( $is_partial ) {
			include $path;

			return;
		}
		load_template( $path );
	}
}
