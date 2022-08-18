# HTMXpress

[HTMX](https://htmx.org/) for WordPress!

By using the [Rewrite Endpoints API](https://make.wordpress.org/plugins/2012/06/07/rewrite-endpoints-api/) to create a
custom endpoint; and a bit of custom template logic, we can output a serverside partial or custom theme template.

Using this setup, WordPress can leverage HTML over the wire solutions such as HTMX.

HTMX then allows us to do dynamic serverside based rendering; live search and other features without the overhead and
complexity of reactive JavaScript frameworks, whilst benefiting from trusted object and full page caching solutions. This repository is exploring the opportunities.

## Demo

1. Activate plugin.
2. go to `/htmx` (Endpoint test)
3. go to `/htmx/ascii` and `/html/partial-ascii` (template loader test)
4. Inspect html source of theme (enqueued script test)
5. go to `/htmx/demo`

What else can you do?

- CSS Transitions https://htmx.org/docs/#css_transitions
- Boosting https://htmx.org/docs/#boosting
- Polling + Server side events
- Progressbars (eg serverside file upload processing) https://htmx.org/examples/progress-bar/
- More examples https://htmx.org/examples/

## Screencast of Demo

https://user-images.githubusercontent.com/594871/183612860-b2eb29f7-cfa0-4de1-97fc-b2a5f393cfd2.mp4
