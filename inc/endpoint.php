<?php
/**
 * Register endpoints.
 */

namespace HtmxPress\Endpoint;

const HTMX_ENDPOINT = 'htmx';

/**
 * Register HTMX templates endpoint.
 *
 * @return void
 */
function register() : void {
	// creates /htmx and htmx query var
	add_rewrite_endpoint( HTMX_ENDPOINT, EP_ROOT );
}
