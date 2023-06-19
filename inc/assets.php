<?php

namespace HtmxPress\Assets;

function bootstrap() {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\register' );
}

function register() {
	// CDN use for prototyping only
	wp_enqueue_script( 'htmx', 'https://unpkg.com/htmx.org@1.8.0' );

	add_post_nonce();
}

function add_post_nonce() {
	$nonce = wp_create_nonce( 'htmx' );
	$data = "window.onload = function() {document.body.addEventListener('htmx:configRequest', (event) => {
        event.detail.headers['X-WP-Nonce'] = '$nonce';
      })}";
	wp_add_inline_script( 'htmx', $data );
}
