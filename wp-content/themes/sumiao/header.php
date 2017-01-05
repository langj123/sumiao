<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sumiaos
 */
$img_size = 'header';
if(is_front_page()){$img_size = 'header_home'; }
$post_thumb = get_post_thumbnail_id(get_the_ID());
if($post_thumb > 0){
	$post_thumb = wp_get_attachment_image_src($post_thumb,$img_size);
}
$bgimage = !empty($post_thumb[0]) ? $post_thumb[0] : false;
if (function_exists('get_field') && is_array(get_field('mobile_header_image', get_the_ID()))) {
	$mobile_img = get_field('mobile_header_image', get_the_ID());
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i,900" rel="stylesheet">

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_stylesheet_directory_uri(); ?>/_img/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(); ?>/_img/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(); ?>/_img/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<?php if (isset($bgimage) || isset($mobile_img)) { ?>
	<style>
		.entry-header {
			background-image: url(<?php echo $bgimage; ?>);
		}
		@media screen and (max-width: 600px) {
			.entry-header {
				background-image: url(<?php echo $mobile_img['url'] ?>);
			}
		}
	</style>
<?php } ?>
</head>

<body <?php body_class(); ?>><?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
<div id="page" class="site">
	<header class="entry-header">
		<div class="title-container">
			<?php
			if ( is_front_page() || is_home() ) { ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
				if (function_exists('get_field')){
					$frontId = get_option('page_on_front');
					$address = get_field('header_address', $frontId) != '' ? get_field('header_address', $frontId) : false;
					$social = array();
					$fb = get_field_object('facebook_link', $frontId)['value'] != '' ? array_push($social, get_field_object('facebook_link', $frontId)) : false;
					$twit = get_field_object('twitter_link', $frontId)['value'] != '' ? array_push($social, get_field_object('twitter_link', $frontId)) : false;
					$inst = get_field_object('instagram_link', $frontId)['value'] != '' ? array_push($social, get_field_object('instagram_link', $frontId)) : false;
					$html = '';
					$html .= $address != false ? '<address>' . $address . '</address>' : '';


					if (sizeof($social) > 0) {
						$html .= '<ul class="social-links">';
					}
					for ($x = 0; $x < sizeof($social); $x++) {
						$html .= '<li><a href="' . $social[$x]['value'] . '" class="' . $social[$x]['wrapper']['class'] . '" target="_blank">' . $social[$x]['placeholder'] . '</a></li>';
					}
					if (sizeof($social) > 0) {
						$html .= '</ul>';
						echo $html;
					}
				}
			} // end if ?>
		</div>
	</header><!-- .entry-header -->

	<div id="content" class="site-content">
