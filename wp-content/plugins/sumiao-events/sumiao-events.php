<?php
/*
Plugin Name: Sumiao Events
Plugin URI: http://www.icscreative.com/
Description: Creates a custom content type to store and display Events roles on the site.
Version: 1.0.0
Author: Jacob Lang
Author URI: http://www.icscreative.com/
*/

defined( 'ABSPATH' ) or die( 'No, thank you.' );

add_action( 'init', 'sumiaos_events_init' );
/**
 * Register an event post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */

function sumiaos_events_init() {
	$labels = array(
		'name'               => _x( 'Events', 'post type general name', 'sumiaos-events' ),
		'singular_name'      => _x( 'Event', 'post type singular name', 'sumiaos-events' ),
		'menu_name'          => _x( 'Events', 'admin menu', 'sumiaos-events' ),
		'name_admin_bar'     => _x( 'Events', 'add new on admin bar', 'sumiaos-events' ),
		'add_new'            => _x( 'Add New Event', 'event', 'sumiaos-events' ),
		'add_new_item'       => __( 'Add New Event', 'sumiaos-events' ),
		'new_item'           => __( 'New Event', 'sumiaos-events' ),
		'edit_item'          => __( 'Edit Event', 'sumiaos-events' ),
		'view_item'          => __( 'View Event', 'sumiaos-events' ),
		'all_items'          => __( 'All Events', 'sumiaos-events' ),
		'search_items'       => __( 'Search Events', 'sumiaos-events' ),
		'parent_item_colon'  => __( 'Parent Event:', 'sumiaos-events' ),
		'not_found'          => __( 'No Events found.', 'sumiaos-events' ),
		'not_found_in_trash' => __( 'No Events found in Trash.', 'sumiaos-events' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'events', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions', 'thumbnail')
	);

	register_post_type( 'events', $args );
}

class sumiaos_Single_Event_Widget extends WP_Widget {
	//creates the leadership widget for use across the site
	function __construct() {
		parent::__construct(
			'sumiaos_single_event_widget', // Base ID
			__( 'Sumiao Event', 'sumiaos_single_event_widget' ), // Name
			array( 'description' => __( 'A custom widget for pulling a single event.', 'sumiaos_single_event_widget' ), ) // Args
		);
	}
	public function widget( $args, $instance ) {
		sumiaos_get_single_event($instance);
		wp_enqueue_style('sumiaos_events_css', plugin_dir_url(__FILE__) . '_css/sumiaos-events.css');
	}
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$blurb = ! empty( $instance['blurb'] ) ? $instance['blurb'] : '';
		$dcount = ! empty( $instance['dcount'] ) ? $instance['dcount'] : -1;
		$args = array(
      		'post_type' => 'events',
      		'posts_per_page' => -1
      	);
		$event_query = new WP_Query($args);
		?>
		<div class="sumiaos_event_widget">
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>
			<p><label for="<?php echo $this->get_field_id( 'blurb' ); ?>"><?php _e( 'Additional Details' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'blurb' ); ?>" name="<?php echo $this->get_field_name( 'blurb' ); ?>" type="text" value="<?php echo esc_attr( $blurb ); ?>"></p>
			<p><label for="<?php echo $this->get_field_id( 'dcount' ); ?>"><?php _e( 'Show' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'dcount' ); ?>" name="<?php echo $this->get_field_name( 'dcount' ); ?>">
					<?php
						for($i=0, $len = $event_query->post_count; $i<$len; $i++){
							$postId = $event_query->posts[$i]->ID;
							$leader = $event_query->posts[$i]->post_title;
							$sel = ($dcount == $postId) ? 'selected' : '';
							print '<option value="' . $postId . '" ' . $sel . '>' . $leader . '</option>';
						}
					?>
				</select>
			</p>
		</div>

		<?php 
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['pasttitle'] = ( ! empty( $new_instance['pasttitle'] ) ) ? strip_tags( $new_instance['pasttitle'] ) : '';
		$instance['dcount'] = ( ! empty( $new_instance['dcount'] ) ) ? strip_tags( $new_instance['dcount'] ) : '';
		return $instance;
	}
} // class Foo_Widget

add_action('widgets_init',
     create_function('', 'return register_widget("sumiaos_Single_Event_Widget");')
);



class sumiaos_Events_Widget extends WP_Widget {
	//creates the leadership widget for use across the site

	function __construct() {
		parent::__construct(
			'sumiaos_events_widget', // Base ID
			__( 'Sumiao Events', 'sumiaos_events_widget' ), // Name
			array( 'description' => __( 'A custom widget to display Events listings.', 'sumiaos_events_widget' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		sumiaos_get_events($instance);
		wp_enqueue_style('sumiaos_events_css', plugin_dir_url(__FILE__) . '_css/sumiaos-events.css');
		wp_enqueue_script('sumiaos_events_js', plugin_dir_url(__FILE__) . '_js/sumiaos-events.js', array('jquery'), '1.0.0', true);
		wp_localize_script( 'sumiaos_events_js', 'ajax_events', array(
    		'ajaxurl' => admin_url( 'admin-ajax.php' ),
    		'noposts' => __('No More Events Found', 'Sumiao'),
 		));
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$pasttitle = ! empty( $instance['pasttitle'] ) ? $instance['pasttitle'] : '';
		$blurb = ! empty( $instance['blurb'] ) ? $instance['blurb'] : '';
		$pastblurb = ! empty( $instance['pastblurb'] ) ? $instance['pastblurb'] : '';
		$args = array(
      		'post_type' => 'events',
      		'posts_per_page' => -1,
      		'tax_query' => array(
	    	    	'relation' => 'AND',
	    	    	array('taxonomy' => 'dates', 'field' => 'slug')
	    	)
      	);
		$event_query = new WP_Query($args);
		?>
		<div class="sumiaos_event_widget">
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>
			<p><label for="<?php echo $this->get_field_id( 'blurb' ); ?>"><?php _e( 'Additional Details' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'blurb' ); ?>" name="<?php echo $this->get_field_name( 'blurb' ); ?>" type="text" value="<?php echo esc_attr( $blurb ); ?>"></p>
			<p><label for="<?php echo $this->get_field_id( 'pasttitle' ); ?>"><?php _e( 'Past Title' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'pasttitle' ); ?>" name="<?php echo $this->get_field_name( 'pasttitle' ); ?>" type="text" value="<?php echo esc_attr( $pasttitle ); ?>"></p>
			<p><label for="<?php echo $this->get_field_id( 'pastblurb' ); ?>"><?php _e( 'Additional Details Past Events' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'pastblurb' ); ?>" name="<?php echo $this->get_field_name( 'pastblurb' ); ?>" type="text" value="<?php echo esc_attr( $pastblurb ); ?>"></p>
		</div>

		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['pasttitle'] = ( ! empty( $new_instance['pasttitle'] ) ) ? strip_tags( $new_instance['pasttitle'] ) : '';
		$instance['blurb'] = ( ! empty( $new_instance['blurb'] ) ) ? strip_tags( $new_instance['blurb'] ) : '';
		$instance['pastblurb'] = ( ! empty( $new_instance['pastblurb'] ) ) ? strip_tags( $new_instance['pastblurb'] ) : '';
		return $instance;
	}

} // class Foo_Widget
add_action('widgets_init',
     create_function('', 'return register_widget("sumiaos_Events_Widget");')
);

// Call to events
function sumiaos_get_events($args){
	$topTitle = $args['title'];
	$pastTitle = $args['pasttitle'];
	$blurb = $args['blurb'];
	$pastBlurb = $args['pastblurb'];

	if (function_exists('get_field')) {
    	$args = array(
    	  'post_type' => 'events',
    	  'posts_per_page' => -1,
    	  'post_status' => 'publish',
    	  'orderby' => array('meta_value_num' => 'ASC'),
    	  'meta_query' => array(
    	  'relation' => 'AND',
    	  	array(
    	  		'key' => 'event_date'
    	  	)
    	  )
    	);
	}
	$event_query = new WP_Query($args);

	$contStand = '<div class="entry-content blog-posts archive-posts event-posts">';
	$contStand .= '<div id="AllEvents">';
	$contStand .= !empty($topTitle) ? '<h3 class="widget-title title-spec">' . $topTitle . '</h3>' : '';
	$contStand .= !empty($blurb) ? '<p class="widget-blurb">' . $blurb . '</p>' : '';
	// query for current events
 	if ($event_query->have_posts()) {
    	$y = 0;
		$contStand .= '<div class="current-events events-holder">';

        while ($event_query->have_posts()) {
        	$event_query->the_post();
        	$postId = $event_query->posts[$y]->ID;
        	$title = $event_query->posts[$y]->post_title;
        	$id = $event_query->posts[$y]->slug;
        	$content = apply_filters( 'the_content', $event_query->posts[$y]->post_content);
        	$post_thumb = get_the_post_thumbnail($postId, 'event_thumb');

        	if (function_exists('get_field')){
        		$date = get_field('event_date', $postId);
        		$day = date('l', strtotime($date));
        		$enddate = get_field('event_end_date', $postId);
        		$endDate = !empty($enddate) ? get_field('event_end_date', $postId) : '';
        		$dateStamp = strtotime($date);
        		$website = get_field('event_website', $postId);
        		$click_text = get_field('click_thru_text', $postId);

        		if($endDate != ''){
	        		$startdateraw = strtotime($date);
	        		$enddateraw = strtotime($endDate);

	        		if(date('Y',$startdateraw) == date('Y',$enddateraw)){
		        		//same year
		        		if(date('F',$startdateraw) == date('F',$enddateraw)){
			        		//same month
			        		$date = date('F',$startdateraw).' '.date('j',$startdateraw).'-'.date('j',$enddateraw).', '.date('Y',$startdateraw);
			        	} else {
				        	//different month
			        		$date = date('F j',$startdateraw).' - '.date('F j',$enddateraw).', '.date('Y',$startdateraw);
			        	}
	        		} else {
		        		//different year
		        		$date = date('F j, Y',$startdateraw).' - '.date('F j, Y',$enddateraw);
	        		}
        		}
        	}
           	$contStand .= '<div class="event-cont">';
           	$contStand .= '<div class="event-photo">';
           	$contStand .= $post_thumb;
           	$contStand .= '</div>';
           	$contStand .= '<div class="event-copy">';
           	$contStand .= ($endDate != '') ? '<time>' . $day . ', ' . $date .'</time>' : '<time>' . $day . ', ' . $date . '</time>';
           	$contStand .= '<h4 class="event-title">' . $title . '</h4>';
           	$contStand .= '<div class="event-content">' . $content . '</div>';
           	$contStand .= '</div>';
           	$contStand .= $website != '' ? '<div class="website"><a href="' . $website . '">' . $click_text . '</a></div>' : '';
           	$contStand .= '</div>';

            $y++;
        }
        $contStand .= '</div><!-- .current-events -->';
        wp_reset_query();
    } // end of query check
    else {
    	$contStand .= '<h4 class="event-title">There are no upcoming events or news. Please check back for updates.</h4>';
    }


	$contStand .= '</div><!-- #AllEvents -->';
	$contStand .= '</div><!-- event-posts -->';

	echo $contStand;

}