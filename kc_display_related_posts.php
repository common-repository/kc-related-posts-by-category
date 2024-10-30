<?php 
/*
Core logic to retrieve related posts and then display the same. 
*/

function kc_related_posts_contents($content)
{
  global $single;
  $output = kc_related_posts();
  if (is_single()) {
        return $content . $output;
    } else {
        return $content;
    }
}

// Function to manually display related posts.
function kc_display_related_posts()
{
 $output = kc_related_posts();
 echo $output;
}

//class kc_related_posts {
function kc_related_posts(){
?>
<style type="text/css">
div.img
{
  height:auto;  
  width: <?php
        echo floor(100/get_option('num_posts')) . "%";
?>;
  float: left;
  text-align: center;
}	

div.img img
{
  display: inline;
  margin: 2px;
  height:auto;
  width: auto;
  border: 1px solid #ffffff;
}
div.img a:hover img {border: 1px solid #0000ff;}
div.desc
{
  text-align: center;
  font-weight: normal;
  width: auto;
  margin: 2px;
  padding-bottom:1cm;
}
</style>
<?php 
/* Main logic to display related posts. */
	$NumPosts = get_option('num_posts');
	$current_post = get_the_ID(); 
	$category = get_the_category();
	$catID = get_cat_ID($category[0]->cat_name);
	$args = array( 'numberposts' => $NumPosts, 'post__not_in' => array($current_post), 'orderby' => 'rand', 'order' => 'DESC','post_type' => 'post','category' => $catID, 'post_status' => 'publish' );
	$recent_posts = wp_get_recent_posts($args);
	
	$def_text = get_option('def_text');
	if (empty($recent_posts)) {
		$output = '<div><br /><h4>' . $def_text . '</h4><br /></div>';
		return $output;
		}
	$header_txt = get_option('header_text');
	if(empty($header_txt)){
	$header_txt = ' ';
	}
	$output = '<div><br /><h4><strong>' . $header_txt . '</strong></h4><br /></div><div>';
	$disp_style = get_option('display_style');
	if ($disp_style == "1"){
	foreach( $recent_posts as $post ){
	 	$kgi = kc_get_image(array( 'post_id' => $post["ID"] ));
		$title = trim(stripslashes($post['post_title']));
		$disp_image = get_option('disp_thumbnail');
		if ($disp_image == "1"){
			$output .= '<div class="img"><a href="' . esc_url(get_permalink($post["ID"])) . '"> <img src="' . WP_PLUGIN_URL . '/kc-related-posts-by-category/timthumb.php?src=' . $kgi . '&w=110&h=120&zc=1" alt="Link to' . $title . '" /></a>';
			}
		$disp_title = get_option('disp_title');
		if ($disp_title == "1"){
			$max_chars = get_option('max_char_title');
			if (empty($max_chars)){
				$output .= '<div class="desc"> <a href="' . esc_url(get_permalink($post["ID"])) . '">' . $title  . '</a></div>';
				if ($disp_image == "1"){
					$output .= '</div>';
					}
				}
			else{
				if (strlen($title) > $max_chars){
					$title = substr($title, 0, $max_chars) . '...';
					}
				$output .= '<div class="desc"> <a href="' . esc_url(get_permalink($post["ID"])) . '">' . $title  . '</a></div>';
				if ($disp_image == "1"){
					$output .= '</div>';
					}
				}
			}
		 
	}
	}
	
	if ($disp_style == "2"){
		$output .= '<ul>';
		foreach( $recent_posts as $post ){
	 	$kgi = kc_get_image(array( 'post_id' => $post["ID"] ));
		$title = trim(stripslashes($post['post_title']));
		$output .= '<li><a href="' . esc_url(get_permalink($post["ID"])) . '">' . $title  . '</a></li>';
		}
		$output .= '</ul>';
	}
	
	$credit = get_option('give_credit');
	if ($credit == "2"){
		$output .= '<div style="font-size: 9px; float: left; width: 100%;" ><a href="http://www.searchtechword.com"  title="Search Engine Optimisation, Technology Articles, Wordpress code">SEO|WP developer</a></div>';
		}
	
	$output .= '<br /></div><br /><div style="clear:both;"></div>';
	return $output;
}
?>