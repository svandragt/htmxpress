<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Susty
 */

get_header(); ?>

    <section>
        <header>
            <h1>HTMX DEMO</h1>
            <p>The demos are integration on top of the theme, and do not require theme changes.</p>
        </header><!-- .page-header -->

        <div>
            <h2>Serverside rendering partials</h2>
            <button hx-post="/htmx/partial-ascii" hx-swap="outerHTML">
                Click Me
            </button>

            <hr>

            <h2>Live search in a few lines</h2>
            <input type="text" name="s"
                   hx-get="/htmx/live-search"
                   hx-select="main"
                   hx-trigger="keyup delay:100ms changed"
                   hx-target="#search-results"
                   placeholder="Search..."/>
            <div id="search-results"></div>


        </div>
    </section>
<?php
get_footer();
