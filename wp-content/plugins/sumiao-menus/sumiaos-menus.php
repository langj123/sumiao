<?php
/*
Plugin Name: Sumiaos Menus
Plugin URI: http://www.icscreative.com/
Description: Creates a custom content type to store and display Menus for Sumiaos. Used in conjunction with Page builder
Version: 1.0.0
Author: Jacob Lang
Author URI: http://www.icscreative.com/
*/

defined( 'ABSPATH' ) or die( 'No, thank you.' );

add_action( 'init', 'sumiaos_menus' );
/**
 * Register an event post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function sumiaos_menu_taxonomy() {
    register_taxonomy(
        'menu-category',
        'menus',  //post type name
        array(
            'hierarchical' => true,
            'label' => 'Menu Category',  //Display name
            'query_var' => true
        )
    );
}
add_action( 'init', 'sumiaos_menu_taxonomy');


function sumiaos_menus() {
	$labels = array(
		'name'               => _x( 'Menus', 'post type general name', 'sumiaos-menus' ),
		'singular_name'      => _x( 'Menu', 'post type singular name', 'sumiaos-menus' ),
		'menu_name'          => _x( 'Menus', 'admin menu', 'sumiaos-menus' ),
		'name_admin_bar'     => _x( 'Menus', 'add new on admin bar', 'sumiaos-menus' ),
		'add_new'            => _x( 'Add New Menu', 'menu', 'sumiaos-menus' ),
		'add_new_item'       => __( 'Add New Menu', 'sumiaos-menus' ),
		'new_item'           => __( 'New Menu', 'sumiaos-menus' ),
		'edit_item'          => __( 'Edit Menu', 'sumiaos-menus' ),
		'view_item'          => __( 'View Menu', 'sumiaos-menus' ),
		'all_items'          => __( 'All Menus', 'sumiaos-menus' ),
		'search_items'       => __( 'Search Menus', 'sumiaos-menus' ),
		'parent_item_colon'  => __( 'Parent Menu:', 'sumiaos-menus' ),
		'not_found'          => __( 'No Menus found.', 'sumiaos-menus' ),
		'not_found_in_trash' => __( 'No Menus found in Trash.', 'sumiaos-menus' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'menus', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions', 'thumbnail')
	);

	register_post_type( 'menus', $args );
}


class sumiaos_menus_widget extends WP_Widget {
	//creates the leadership widget for use across the site

	function __construct() {
		parent::__construct(
			'sumiaos_menus_widget', // Base ID
			__( 'sumiaos Menus', 'sumiaos_menus_widget' ), // Name
			array( 'description' => __( 'A custom widget to display Menus.', 'sumiaos_menus_widget' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		sumiaos_get_menus($instance);
		wp_enqueue_style('sumiaos_menu_css', plugin_dir_url(__FILE__) . '_css/sumiaos-menus.css');
		wp_enqueue_script('sumiaos_menu_js', plugin_dir_url(__FILE__) . '_js/sumiaos-menus.js', array('jquery'), '1.0.0', true);
		wp_localize_script( 'sumiaos_menu_js', 'ajax_events', array(
    		'ajaxurl' => admin_url( 'admin-ajax.php' ),
    		'noposts' => __('No More Events Found', 'sumiaos'),
 		));
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$args = array(
      		'post_type' => 'menus',
      		'posts_per_page' => -1
      	);
		$menu_query = new WP_Query($args);
		?>
		<div class="sumiaos_menu_widget">
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>
		</div>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

} // class Foo_Widget
add_action('widgets_init',
     create_function('', 'return register_widget("sumiaos_menus_widget");')
);

// Call to events
function sumiaos_get_menus($args){
	$topTitle = $args['title'] != '' ? $args['title'] : 'Menus';
	$terms = get_terms(array(
	  'taxonomy' => 'menu-category',
	  'orderby' => 'count',
	  'hide_empty' => true,
	  'offset' => 0
	));
	$x = 0;

	$nav = '<div class="menu-tabs"><h3>' . $topTitle . '</h3><ul class="tabs-items">';
	foreach ($terms as $term) {
		$nav .= '<li class="tab-item"><button data-id="' . $term->slug . '-' . $term->term_id . '">' . $term->name . '</button></li>';
	}
	$nav .= '</ul></div><!-- .menu-tabs -->';

	foreach ($terms as $term) {
		if ($x == 0) {
			$contStand .= $nav;
			$contStand .= '<div class="menus-container">';
			$contStand .= '<div id="AllMenus">';
		}

		$args = array(
    	  'post_type' => 'menus',
    	  'posts_per_page' => -1,
    	  'post_status' => 'publish',
    	  'tax_query' => array(
    	  		array(
    	  			'taxonomy' => 'menu-category',
    	  			'field' => 'slug',
    	  			'terms' => $term->slug
    	  		)
    	  	),
    	);

		$menu_query = new WP_Query($args);


 		if ($menu_query->have_posts()) {
    		$y = 0;
    		$contStand .= '<div class="menu-category-cont" id="' . $term->slug . '-' . $term->term_id .'">';
    		$colLeft = '<div class="col-left">';
    		$colRight = '<div class="col-right">';

    	    while ($menu_query->have_posts()) {
    	    	$menu_query->the_post();
    	    	$postId = $menu_query->posts[$y]->ID;
    	    	$title = $menu_query->posts[$y]->post_title;
    	    	$id = $menu_query->posts[$y]->slug;
    	    	$content = apply_filters( 'the_content', $menu_query->posts[$y]->post_content);

    	    	if ($y % 2 == 0) {
	    			$colLeft .= '<div class="menu-cont">';
	    			$colLeft .= '<h2 class="menu-title">' . $title . '</h2>';
	    			$colLeft .= $content;
    	    		$colLeft .= '</div><!-- .menu-cont -->';
    	    	} else {
    	    		$colRight .= '<div class="menu-cont">';
	    			$colRight .= '<h2 class="menu-title">' . $title . '</h2>';
	    			$colRight .= $content;
    	    		$colRight .= '</div><!-- .menu-cont -->';
    	    	}

        	    $y++;
        	} // end while loop
        	$contStand .= $colLeft . '</div>';
        	$contStand .= $y > 0 ? $colRight . '</div>' : '';
        	$contStand .= '</div><!-- .menu-category-cont -->';

    		wp_reset_query();
    	} // end of query check

    	if ($x == (sizeof($terms) - 1)) {
    		$contStand .= '</div><!-- #AllMenus -->';
			$contStand .= '</div><!-- #menus-container -->';
    	}
    	$x++;
    } // end of foreach

	echo $contStand;

}