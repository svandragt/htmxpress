<?php

namespace HTMXPress\Assets;

function bootstrap() {
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\register' );
}

function register() {
	wp_enqueue_script( 'htmx', 'https://unpkg.com/htmx.org@1.8.0' );
}
