<?php

namespace HTMX\Template;

use const HTMX\Endpoint\HTMX_ENDPOINT;

function bootstrap() {
	add_action( 'template_redirect', __NAMESPACE__ . '\\render' );
}

function render() {
	global $wp_query;
	if ( ! isset( $wp_query->query_vars[ HTMX_ENDPOINT ] ) ) {
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

function load_template_or_404( $template_name ) {
	$path = dirname(dirname( __FILE__ ) ). "/templates/${template_name}.php";
	global $wp_query;
	if ( ! file_exists( $path ) ) {
		$wp_query->set_404();
		status_header( 404 );
		return '404';
	} else {
		$is_partial = str_starts_with( $template_name, 'partial-' );
		if ($is_partial) {
			return include $path;
		}
		load_template( $path);
	}
}
