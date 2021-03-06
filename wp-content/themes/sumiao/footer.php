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
	if (function_exists('get_field')) {
		$frontId = get_option('page_on_front');
		$jobs = get_field('job_listings', $frontId) != '' ? get_field('job_listings', $frontId) : false;


	}
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo"><div class="col-6">
		<?php if ($jobs != false) { ?>
			<h3>We're Hiring</h3>
			<a href="<?php echo $jobs; ?>" target="_blank">Learn More</a>
		<?php } ?>
		</div><div class="col-6">
			<h3>Press Inquiries</h3>
			<a href="mailto:info@sumiaohunan.com">Contact Us</a>
		</div>

	</footer><!-- #colophon -->
	<div class="ext-link">Site by <a href="http://icscreative.com/">ICS</a></div>
</div><!-- #page -->


<?php wp_footer(); ?>

</body>
</html>
