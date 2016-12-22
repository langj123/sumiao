<?php
/**
 * The template for resourc library
 *
 */
$queried = get_queried_object();
$mainTitle = $queried->labels->singular_name;
$cont = '<header class="headline-wrap entry-header archive-header">';
$cont .= '<div class="title-container">';
$cont .= '<h1 class="entry-title title-heavy">' . $mainTitle . '</h1>';
$cont .= '</div>';
$cont .= '</header>';
?>
<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
				echo $cont;
				the_widget('Ann_ResourcesFilter_Widget');
				the_widget('Ann_ResourcesLibrary_Widget');
				// get_template_part('template-parts/content', 'custom-post');
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();