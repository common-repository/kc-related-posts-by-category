<?php
/*
The main admin page for this plugin. The logic for different user input and form submittion is written here. 
*/

function kc_related_post_admin_menu() {
add_options_page('KC Related Posts By Category', 'KC Related Posts By Category', 'administrator',
'kc-related-post', 'kc_related_post_admin_page');
}

function kc_post_style($val, $post_style)
{
    $return_val = ($val == $post_style) ? "selected='selected'" : "";
    return $return_val;
}

function kc_related_post_admin_page() {
if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
?>

<div id="icon-options-general" class="icon32"></div>
<h2>KC Related Posts By Category</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<table width="210" class="form-table">
<tbody>
<tr valign="top" align="left">
<th scope="row"><strong>Auto Display </strong>(This will display related posts after post contents automatically)</th>
<td>
<?php 	$ckd = ( "1" == get_option('auto_display')) ? "checked=checked" : "";  ?>
<input name="auto_display" type="checkbox" id="auto_display"
value="1"   <?php echo $ckd ?> /> 
</td>
</tr>
<tr valign="top" align="left">
<th scope="row"><strong>Place this code for manual display </strong></th>
<td>
<code>&lt;?php if(function_exists(&#39;kc_display_related_posts&#39;)) kc_display_related_posts(); ?&gt;</code>
</td>
</tr>

<tr valign="top" align="left">
<th  scope="row"><strong>Header Text</strong></th>
<td>
<input name="header_text" type="text" id="header_text"
value="<?php echo get_option('header_text'); ?>" />
(ex. Related Posts)</td>
</tr>
<tr valign="top" align="left">
<th scope="row"><strong>Number of Posts to Display </strong>(Please select max 5 in case of horizontal display for better output)</th>
<td>
<input name="num_posts" type="text" id="num_posts"
value="<?php echo get_option('num_posts'); ?>" />
</td>
</tr>
<tr valign="top" align="left">
<th scope="row"><strong>Display Thumbnail</strong></th>
<td>
<?php 	$ckd = ( "1" == get_option('disp_thumbnail')) ? "checked=checked" : "";  ?>
<input name="disp_thumbnail" type="checkbox" id="disp_thumbnail"
value="1"   <?php echo $ckd ?> /> 
</td>
</tr>
<tr valign="top" align="left">
<th  scope="row"><strong>Display Title</strong></th>
<td >
<?php 	$ckd = ( "1" == get_option('disp_title')) ? "checked=checked" : "";  ?>
<input name="disp_title" type="checkbox" id="disp_title"
value="1"   <?php echo $ckd ?> /> 
</td>
</tr>
<tr valign="top" align="left">
<th  scope="row"><strong>Max Number of chars for Title</strong> (If set to null then full title will be displayed)</th>
<td>
<input name="max_char_title" type="text" id="max_char_title"
value="<?php echo get_option('max_char_title'); ?>" />
</td>
</tr>
<tr valign="top" align="left">
<th scope="row"><strong>Display Style</strong> (Vertical Style wont display thumbnail)</th>
<td>

<select name="display_style" id="display_style"><option>--Select--</option>
	<option value="1"  <?php echo kc_post_style(1, get_option('display_style')) ?> >Horizontal Format</option>
	<option value="2"  <?php echo kc_post_style(2, get_option('display_style')) ?> >Vertical Format</option>
</select>	
</td>
</tr>

<tr valign="top" align="left">
<th  scope="row"><strong>Default Text</strong> (When no related posts found)</th>
<td>
<input name="def_text" type="text" id="def_text"
value="<?php echo get_option('def_text'); ?>" />
(ex. No Related Posts)</td>
</tr>
</tr>

<tr valign="top" align="left">
<th scope="row"><strong>Give Credit</strong></th>
<td>
<?php 	$ckd = ( "2" == get_option('give_credit')) ? "checked=checked" : "";  ?>
<input name="give_credit" type="checkbox" id="give_credit"
value="2"   <?php echo $ckd ?> /> 
</td>
</tr>
</tbody>
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="auto_display,header_text,num_posts,disp_thumbnail,disp_title,max_char_title,display_style,def_text,give_credit" />

<p>
<input type="submit" value="<?php _e('Update Options') ?>" class="button-primary" />
</p>

</form>

<?php
}


?>