# HTMXpress

[HTMX](https://htmx.org/) for WordPress!

By using the [Rewrite Endpoints API](https://make.wordpress.org/plugins/2012/06/07/rewrite-endpoints-api/) to create a
custom endpoint; and a bit of custom template logic, we can output a serverside partial or custom theme template.

Using this setup, WordPress can leverage HTML over the wire solutions such as HTMX.

HTMX then allows us to do dynamic serverside based rendering; live search and other features without the overhead and
complexity of reactive JavaScript frameworks, whilst benefiting from trusted object and full page caching solutions.
This repository is exploring the opportunities.

## Demo

1. Activate plugin (or run `wp-env start` to spin up a WP environment with the plugin activated).
2. go to `/htmx` (Endpoint test)
3. go to `/htmx/ascii` and `/html/partial-ascii` (template loader test)
4. Inspect html source of theme (enqueued script test)
5. go to `/htmx/demo`

What else can you do?

- CSS Transitions https://htmx.org/docs/#css_transitions
- Boosting https://htmx.org/docs/#boosting
- Polling + Server Sent Events https://htmx.org/docs/#sse
- Progressbars (eg serverside file upload processing) https://htmx.org/examples/progress-bar/
- More examples https://htmx.org/examples/

## Screencast of Demo

https://user-images.githubusercontent.com/594871/183612860-b2eb29f7-cfa0-4de1-97fc-b2a5f393cfd2.mp4

# Project use



1. __By default HTMX is loaded from an external CDN__. While the CDN approach is extremely simple, you may want
   to [consider not using CDNs in production](https://blog.wesleyac.com/posts/why-not-javascript-cdn): Download a 
   [minified copy of htmx](https://unpkg.com/htmx.org/dist/htmx.min.js) and put it into
the `mytheme/third-party/` folder so WordPress can find it, updating the version number.

```php
# mytheme/functions.php
const PRIORITY_AFTER_HTMX = 20;
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_script( 'htmx');
    wp_enqueue_script( 'htmx', trailingslashit( dirname( __FILE__ ) ) . 'third-party/htmx.min.js', '1.9.2' );
}, PRIORITY_AFTER_HTMX );
```


2. __Add your own templates to the htmx endpoint__: Here's how to add to the template paths to point to your site's templates:

```php
# mytheme/functions.php
add_filter( 'htmx.template_paths', static function ( $paths ) {
	$paths[] = __DIR__ . '/templates';

	return $paths;
} );

# A template mytheme/templates/example.php will then be accessible from `/htmx/example`
```
