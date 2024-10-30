<?php
/*
Plugin Name: KC Related Posts by Category
Description: WordPress plugin for related posts by category using wordpress function. Fast and simple.
Author: Kunal Chichkar
Author URI: http://www.kunalchichkar.com
Plugin URI: http://www.searchtechword.com
Version: 1.0
License: GPL
*/
require_once('kc_get_display_image.php');
require_once('kc_admin_page.php');
require_once('kc_display_related_posts.php');


if (!function_exists('is_admin')) 
{
header('Status: 403 Forbidden');
header('HTTP/1.1 403 Forbidden');
exit();
}


/* Runs when plugin is activated */
register_activation_hook(__FILE__,'kc_related_post_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'kc_related_post_remove' );


function kc_related_post_install() 
{
/* Creates new database field */
add_option("auto_display",'1','','yes');
add_option("header_text",'Related Posts: ','','yes');
add_option("num_posts",'4','','yes');
add_option("disp_thumbnail",'1','','yes');
add_option("disp_title",'1','','yes');
add_option("max_char_title",'50','','yes');
add_option("display_style",'1','','yes');
add_option("def_text",'No Related Posts','','yes');
add_option("give_credit",'1','','yes');
}

function kc_related_post_remove() {
/* Deletes the database field */
delete_option('auto_display');
delete_option('header_text');
delete_option('num_posts');
delete_option('disp_thumbnail');
delete_option('disp_title');
delete_option('max_char_title');
delete_option('display_style');
delete_option('def_text');
delete_option('give_credit');
}

if(is_admin())
{
add_action('admin_menu', 'kc_related_post_admin_menu');
}
else
{
 $auto_display = get_option('auto_display');
 if($auto_display == "1")
 {
  add_filter('the_content', 'kc_related_posts_contents');
 } 
}
?>