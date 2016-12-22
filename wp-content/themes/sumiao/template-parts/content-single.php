<?php
if(have_posts()) {

 while (have_posts()) { the_post();
    $postId = get_the_id();
    $genImg = array(9650,9685,9686,9687,9688,9689,9690,9691,9692,9693); //set an arry of the attachment IDs of the 10 generic images used on posts that have poor quality or no featured image set
	//get the last number of the post id and use it (0-9) to choose which $featImg element is used as the generic image for thist post if it's featured image is not of high enough quality. presents consistent images while somewhat random instead of purely random images that don't match frmo blog lander to blog post display
	$lpid = substr($postId,-1,1);


	$featImageId = get_post_thumbnail_id($postId);
	if(!$featImageId > 0){
		$featImageId = $genImg[$lpid];
	}
	$featImage = wp_get_attachment_image_src($featImageId,'header_post');

	$imgurl = $featImage[0];
	$check_thumb = strpos($imgurl,'1000x570'); // check if 1000x570 is in the file name - these are the pixel dimensions of a 'header_post' image size
	if(!$check_thumb){
		//if the image displayed is not the correct size, use the default so it's not a pixelated old image
		$featImage = wp_get_attachment_image_src($genImg[$lpid],'header_post');
	}

    $time = get_the_time('l, F jS, Y');
    $title = get_the_title();
    $categories = get_the_category();
    $post_content = get_the_content();
    $post_content = apply_filters( 'the_content', $post_content );
    $post_content = (siteorigin_panels_render()) ? $post_content : '<div class="normal-post">' . $post_content . '</div>';
    $aut_id = get_the_author_meta('ID');
    $aut_first = get_the_author_meta('first_name' ) ? get_the_author_meta('first_name' ) : get_the_author();
    $aut_last = get_the_author_meta('last_name' ) ? get_the_author_meta('last_name' ) : '';
    $aut_rol = get_the_author_meta('nickname') ? get_the_author_meta('nickname') : 'Awesome Employee';
    $aut_twit = (function_exists('get_field') && get_field('user_twitter_url', 'user_' . $aut_id)) ? get_field('user_twitter_url', 'user_' . $aut_id) : false;
    $aut_linkd = (function_exists('get_field') && get_field('user_linkedin_url', 'user_' . $aut_id)) ? get_field('user_linkedin_url', 'user_' . $aut_id) : false;

    // build content for display
    $cont = '';

    $cat_output = '<ul class="cat-list">';
        if (!empty($categories)) {
          foreach ($categories as $category) {
            $cat_output .= '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="" >' . $category->name . '</a></li>';
          }
        }
    $cat_output .= '</ul>';

    $cont .= '<article id="post-' . $postId . '">';
    $cont .= '<header class="headline-wrap entry-header" style="background-image: url(' . $featImage[0] .');">';
    $cont .= '</header>';
    $cont .= '<div class="article-cont">';
    $cont .= '<div class="entry-content">';
    $cont .= '<div class="cont-extra">';
    $cont .= '<div class="article-head">';
    $cont .= '<div class="head-wrap">';
    $cont .= '<h1 class="article-title">' . $title . '</h1>';
    $cont .= '</div>';
    $cont .= '</div>';
    $cont .= $post_content;
    $cont .= '<footer class="article-footer">';
    $cont .= '<div class="author-cont">';
    $cont .= get_avatar(get_the_author_meta( 'ID' ), 110);
    $cont .= '<p class="pre-author">Posted By</p>';
    $cont .= '<dl class="author-def">';
    $cont .= '<dt class="user-name">' . $aut_first . ' ' .  $aut_last . '</dt>';
    // $cont .= '<dd class="user-role">' . $aut_rol . '</dd>';
    $cont .= '</dl>';
    $cont .= ($aut_twit != false || $aut_linkd != false) ? '<ul class="author-soc social">' : '';
    $cont .= ($aut_twit != false) ? '<li class="soc-twit"><a href="' . $aut_twit . '" target="_blank">Twitter Link</a></li>' : '';
    $cont .= ($aut_linkd != false) ? '<li class="soc-linkd"><a href="' . $aut_linkd . '" target="_blank">LinkedIn Link</a></li>' : '';
    $cont .= ($aut_twit != false || $aut_linkd != false) ? '</ul>' : '';
    $cont .= '<a href="' . get_author_posts_url(get_the_author_meta("ID")) . '" class="button">View all of ' . $aut_first . '\'s posts</a>';
    $cont .= '</div>';
    $cont .= '</footer>';
    $cont .= '</div>';
    $cont .= '</div>';
    $cont .= '</div>';
    $cont .= '</article>';

    echo $cont;

  }
}
get_template_part( 'template-parts/content', 'adjacent-posts' );
?>