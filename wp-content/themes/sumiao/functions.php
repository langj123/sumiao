<?php
/**
 * Sumiaos functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sumiaos
 */

require_once(get_template_directory() . '/inc/extend-classes.php');


if ( ! function_exists( 'sumiaos_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sumiaos_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on sumiaos, use a find and replace
	 * to change 'sumiaos' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'sumiaos', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'sumiaos' ),
		'partial' => esc_html__( 'Partial Main Navigation', 'sumiaos' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'sumiaos_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'sumiaos_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sumiaos_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sumiaos_content_width', 640 );
}
add_action( 'after_setup_theme', 'sumiaos_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sumiaos_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Above Footer', 'sumiaos' ),
		'id'            => 'sidebar-above-footer',
		'description'   => esc_html__( 'Add widgets here.', 'sumiaos' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer', 'sumiaos' ),
		'id'            => 'sidebar-footer',
		'description'   => esc_html__( 'Add widgets here.', 'sumiaos' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'sumiaos_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function sumiaos_scripts() {
	wp_enqueue_style( 'sumiao-fonts', 'https://fast.fonts.net/cssapi/c87c8d58-36e0-42ff-b3f8-99e317affb9f.css' );
	wp_enqueue_style( 'sumiaos-social-fonts', 'https://file.myfontastic.com/n6vo44Re5QaWo8oCKShBs7/icons.css' );
	wp_enqueue_style( 'sumiaos-custom-style', get_template_directory_uri() . '/css/style-sumiaos.css' );
	wp_enqueue_script( 'sumiaos-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'sumiaos-jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'gsap-js', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/TweenMax.min.js', array('jquery'), false, true );
	wp_enqueue_script( 'gsap-css', 'http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/CSSPlugin.min.js', array('jquery', 'gsap-js'), false, true );
	wp_enqueue_script( 'sumiaos-custom-js', get_template_directory_uri() . '/js/sumiaos.js', array('jquery', 'gsap-js', 'gsap-css'), '20160623', true );

	wp_enqueue_script( 'sumiaos-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script( 'munchkin', get_template_directory_uri() . '/js/munchkin.js', array(), '1.0.0', true );

	if (is_singular('resources-library') || is_page_template('page-marketo.php') || is_page_template('page-marketo-footer.php')) {

		wp_enqueue_script( 'munchkin-init', 'http://app-ab16.marketo.com/js/forms2/js/forms2.min.js', array('munchkin'), '1.0.0', true );
		wp_enqueue_script( 'munchkin-login', get_template_directory_uri() . '/js/munchkin-login.js', array('munchkin','munchkin-init'), '1.0.0', true );
	}
	if (is_home()) {
		wp_enqueue_script( 'post-ajax', get_template_directory_uri() . '/js/post-ajax.js', array('jquery'), '1.0.0', true );

		wp_localize_script( 'post-ajax', 'ajax_posts', array(
    		'ajaxurl' => admin_url( 'admin-ajax.php' ),
    		'noposts' => __('No older posts found', 'sumiaos'),
 		));
	}
	if (is_page_template('page-sub-pages.php')) {
		wp_enqueue_script( 'navigation-effects', get_template_directory_uri() . '/js/navigation-effect.js', array('jquery'), '1.0.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'sumiaos_scripts' );


function more_post_ajax(){

    $ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 6;
    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
    $cid = (isset($_POST['cat'])) ? $_POST['cat'] : 0;
    $aut = (isset($_POST['author'])) ? $_POST['author'] : false;
    $offset = (isset($_POST['offset'])) ? $_POST['offset'] : false;
    $y = 0;

    header("Content-Type: text/html");

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $ppp,
        'cat' => $cid,
        'author' => $aut,
        'paged'    => $page,
        'offset' => $offset,
        'post_status' => 'publish'
    );


    $loop = new WP_Query($args);

    $out = '';

    if ($loop -> have_posts()) {
    	$y = 0;
    	
    	while ($loop -> have_posts()) { $loop -> the_post();

        $postId = $loop->posts[$y]->ID;
        $post_categories = wp_get_post_categories($postId);
        //$url = $loop->posts[$y]->guid;
        $url = get_permalink($postId);
        $title = $loop->posts[$y]->post_title;
		$post_cat = wp_get_post_categories($postId);
        $date = get_the_time('F j, Y');

	    $genImg = array(9650,9685,9686,9687,9688,9689,9690,9691,9692,9693); //set an arry of the attachment IDs of the 10 generic images used on posts that have poor quality or no featured image set
		//get the last number of the post id and use it (0-9) to choose which $featImg element is used as the generic image for thist post if it's featured image is not of high enough quality. presents consistent images while somewhat random instead of purely random images that don't match frmo blog lander to blog post display
		$lpid = substr($postId,-1,1); 

		$featImageId = get_post_thumbnail_id($postId);
		if($featImageId > 0){
			$featImage = wp_get_attachment_image_src($featImageId,'header_post');
		} else {
			$featImage = wp_get_attachment_image_src($genImg[$lpid],'header_post');
		}
		$imgurl = $featImage[0];
		$check_thumb = strpos($imgurl,'1000x570'); // check if 1000x570 is in the file name - these are the pixel dimensions of a 'header_post' image size to make sure it's consistent with the thumb
		if(!$check_thumb){
			//if the image displayed is not the correct size, use the default so it's not a pixelated old image
			$featImage = wp_get_attachment_image_src($genImg[$lpid],'blog_thumb');
		} else {
			$featImage = wp_get_attachment_image_src($featImageId,'blog_thumb');
		}
		
      $cats = '<ul class="post-category-list">';
	  $cats .= '<li>'.ann_post_primary_category($postId,'text').'</li>';
#      foreach ($post_cat as $id) {
#        $catInfo = get_category($id);
#        $cats .= '<li><a href="' . get_category_link($catInfo->term_id) . '">' . $catInfo->name . '</a></li>';
#      }
      $cats .= '</ul>';

        $out .= '<div class="post-cont">';
        $out .= '<div class="article-head">';
        $out .= '<div class="head-wrap">';
        $out .= '<img src="' . $featImage[0] . '" class="post-image" />';
        $out .= $cats;
        $out .= '<h2 class="post-title"><a href="' . $url .'">' . $title . '</a></h2>';
        #$out .= '<div class="post-date"> ' . $date . '</div>';
        $out .= '</div>';
        $out .= '</div>';
        $out .= '</div>';

        $y++;

        }
        wp_reset_postdata();
    }
    die($out);
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

add_filter('single_template', 'single_template_terms');
function single_template_terms($template) {
    foreach( (array) wp_get_object_terms(get_the_ID(), get_taxonomies(array('public' => true, '_builtin' => false))) as $term ) {
        if ( file_exists(TEMPLATEPATH . "/single-{$term->slug}.php") )
            return TEMPLATEPATH . "/single-{$term->slug}.php";
    }
    return $template;
}

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


add_image_size('event_thumb',682,513,true);

/* start sessions to track page id if auth from marketo */
add_action('init', 'myStartSession', 1);
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}

// container for video
add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;

function custom_oembed_filter($html, $url, $attr, $post_ID) {
    $return = '<div class="video-container">'.$html.'</div>';
    return $return;
}

