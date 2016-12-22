<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Annuitas
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="footer_area">
			<div class="footer_widgets"><?php dynamic_sidebar('sidebar-footer'); ?></div><div class="footer_nav"><?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'footer-menu' ) ); ?></div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php get_template_part( 'template-parts/content', 'filters' );?>


<?php wp_footer(); ?>

</body>
</html>
