<?php
/**
 * The template for displaying 404 pages.
 *
 * @package aos
 */

get_header(); ?>
	<div class="site-main">
		<main class="content c_single" id="main" role="main">
			<article class="page-404">
				<div class="t404"><?php esc_html_e( '404', 'aos' ); ?></div>
				<h1><?php esc_html_e( 'Page Not Found!', 'aos' ); ?></h1>
			</article>
		</main>
	</div>
<?php get_footer(); ?>