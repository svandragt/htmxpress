<?php
/**
 * Asset registration and noncing.
 */

namespace HtmxPress\Assets;

/**
 * Bootstrap the asset registration.
 *
 * @return void
 */
function bootstrap() : void {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\register' );
}

/**
 * Register the htmx script.
 *
 * @return void
 */
function register() : void {
	// CDN use for prototyping only.
	wp_enqueue_script( 'htmx', 'https://unpkg.com/htmx.org@1.9.10', [], null, [ 'strategy' => 'defer'] );
	add_post_nonce();
}

/**
 * Inline script to add a nonce to pages.
 *
 * @return void
 */
function add_post_nonce() : void {
	// PHP sees this as 'HTTP_X_WP_NONCE' in _SERVER.
	$nonce = wp_create_nonce( 'htmx' );
	$data = 'window.onload = function() {document.body.addEventListener("htmx:configRequest", (event) => {
        event.detail.headers["X-WP-Nonce"] = ' . wp_json_encode( $nonce ) . ';
      })}';
	wp_add_inline_script( 'htmx', $data );
}
