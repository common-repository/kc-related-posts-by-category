<?php
/*
This script will go through different possible options to retrive the display image associated with each post.  
*/
function kc_get_image($args = array() ) 
{
 global $post;
 
 $defaults = array('post_id' => $post->ID);
 $args = wp_parse_args( $args, $defaults );
 
 /* Get the first image if it exists in post content.  */
// $final_img = get_image_in_post_content($args);
 $final_img = get_image_from_post_thumbnail($args);
 
 
 if(!$final_img)
 $final_img = get_image_from_attachments($args);
 
 if(!$final_img)
 $final_img = get_image_in_post_content($args);
 
 if(!$final_img){ //Defines a default image
 $final_img = WP_PLUGIN_URL . '/kc-related-posts-by-category/noimage.gif';
 } else {
  $final_img = str_replace($url, '', $final_img);
 }
  return $final_img;
  
}

/* Function to search through post contents and return the first available image in the content.*/

function get_image_in_post_content($args = array() )
{
 $display_img = '';
 $url = get_bloginfo('url');
 ob_start();
 ob_end_clean();
 $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field( 'post_content', $args['post_id'] ), $matches);
 $display_img = $matches [1] [0];
 $not_broken = @fopen("$display_img","r"); // checks if the image exists
 if(empty($display_img) || !($not_broken)){ //Defines a default image
 unset($display_img);
 } else {
  $display_img = str_replace($url, '', $display_img);
 }
 return $display_img;
 
}


/* 
Function to find image using WP available function get_the_post_thumbnail(). 
Note: This function will be available only if your theme supports the same.
Post Thumbnail is a theme feature introduced with Version 2.9. 

Themes have to declare their support for post images before the interface for assigning these images will appear on the Edit Post and Edit Page screens. They do this by putting the following in their functions.php file:

if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}
 */

function get_image_from_post_thumbnail($args = array())
{
	if (function_exists('has_post_thumbnail')) {
		if (has_post_thumbnail( $args['post_id']))
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $args['post_id'] ), 'single-post-thumbnail' );
	}
 	return $image[0];

}


function get_image_from_attachments($args = array())
{
	if (function_exists('wp_get_attachment_image')) {
	$children = get_children(
	array(
	'post_parent'=> $args['post_id'],
	'post_type'=> 'attachment',
	'numberposts'=> 1,
	'post_status'=> 'inherit',
	'post_mime_type' => 'image',
	'order'=> 'ASC',
	'orderby'=> 'menu_order ASC'
	)
	);

	if ( empty( $children ))
		return false;

	$image = wp_get_attachment_image_src( $children[0], 'thumbnail');
	return $image;
	}

}
?>