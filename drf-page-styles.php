<?php
/*
Plugin Name: Digital Raindrops Page Styles
Version: 0.1
Plugin URI: http://www.digitalraindrops.net/Boards/Topic.aspx?TopicID=5/
Author: David Cox (email: david.cox@digitalraindrops.net)
Author URI: http://www.digitalraindrops.net//
Donation URI: http://www.digitalraindrops.net/
Demo URI: http://digitalraindrops.net/demo/wordpress/style-swapper/
Description: This plugin enables admin users of WordPress to assign a different Style Sheets per page from the themes directory. 
Requires at least: 2.7
Tested up to: 2.9
*/

/* Prevent direct access to this file */
if (!defined('ABSPATH')) {
	exit(__( "Sorry, you are not allowed to access this file directly.",'Digital Raindrops'));
}

define("MANAGEMENT_PERMISSION", "edit_themes");

//Stylesheet function returns any selected stylesheet on header load
function drf_stylesheet() {
	$pagename = drf_curr_page_name();
	$pageid = drf_get_unique_id($pagename);
	if (drf_get_settings($pageid)!='Default') {
		echo '<link rel="stylesheet" href="';
		echo drf_get_themes_url().'/'.drf_get_settings($pageid).'/style.css" type="text/css" media="screen" />'."\n";
		} else { 
			return;
		}
}
add_action('wp_print_styles', 'drf_stylesheet');

/* Get the unique ID for the theme and page */
function drf_get_unique_id($pagetitle)
{
	$themename = stripslashes(get_current_theme());
	$pageid = str_replace(" ","_",$themename);
	$pageid = $pageid."_";
	$pageid = $pageid.str_replace(" ","_",$pagetitle);
	return $pageid;
}

/* Get the current selected page */
function drf_curr_page_name() {
	global $post;
 return stripslashes($post->post_title);
}

/* returns the path to the themes directory */
Function drf_get_themes_url(){
 return bloginfo('wpurl').'/wp-content/themes';
}

// Insert or update the page style record
function drf_update_option($optionname, $optionvalue){
	if ((!$optionname) || (!$optionvalue)) return;
	global $wpdb;
	$drftablename = $wpdb->prefix . "drf_plugins";
	$pluginname = 'page_styles';
	$themename = stripslashes(get_current_theme());
	$theid = $wpdb->get_var("SELECT id FROM {$drftablename} WHERE option_name = '{$optionname}'");
	if ($theid) {
		$wpdb->query("UPDATE {$drftablename} SET option_value = '{$optionvalue}'  WHERE id='{$theid}'");
	} else {
		$wpdb->query("INSERT INTO {$drftablename}
			(blog_id, plugin_name, theme_name, option_name, option_value)
			VALUES ('0', '{$pluginname}', '{$themename}', '{$optionname}', '{$optionvalue}')
		");
	}
}

// Get the page style record
function drf_get_settings($optionname){
	global $wpdb;
	$drftablename = $wpdb->prefix . "drf_plugins";
	$thevalue = $wpdb->get_var("SELECT option_value FROM {$drftablename} WHERE option_name = '{$optionname}'");
	if ($thevalue) {
		return $thevalue;
	}else{	
		return "";
	}
}

//Install
function drf_options_install () {
	require_once(dirname(__FILE__).'/drf-installer.php');
}
register_activation_hook(__FILE__,'drf_options_install');

//Add the Admin Menus
if (is_admin()) {
	require_once(dirname(__FILE__).'/adminmenu.php');
	//Check the install is ok
	$Holder = drf_get_settings('installed_ok');
	if (!Holder){
		update_option("drf_wp_db_version", '');
		require_once(dirname(__FILE__).'/drf-installer.php');
		$Holder = drf_get_settings('installed_ok');
		if (Holder) drf_update_option('installed_ok',true);	
	}
}

/*
Copyright 2010 David Cox (email: david.cox@digitalraindrops.net)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>