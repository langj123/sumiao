<?php
/**
 * The template for displaying all single careers pages
 *
 *
 * @package Annuitas
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php get_template_part( 'template-parts/content', 'in-the-news' ); ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer('nodemand');
