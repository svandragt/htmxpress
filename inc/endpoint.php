<?php

namespace HTMXPress\Endpoint;

const HTMX_ENDPOINT = 'htmx';

function register() : void {
	// creates /htmx and htmx query var
	add_rewrite_endpoint( HTMX_ENDPOINT, EP_ROOT );
}
