<?php
/*	This file is part of the Digital Raindrops Page Styles Plugin */
/*	Copyright 2010 David Cox  (email : david.cox@digitalraindrops.net) */

/* Prevent direct access to this file */
if (!defined('ABSPATH')) {
	exit(__( "Sorry, you are not allowed to access this file directly.",'Digital Raindrops'));
}

// Install
require_once(ABSPATH . 'wp-admin/upgrade.php');
// Install variables
global $wpdb;
$table_name = $wpdb->prefix . "drf_plugins";
$drf_wp_db_version = "1.0.0";


// Create Table 
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
$sql = "CREATE TABLE " . $table_name . " (
	  id bigint(20) UNSIGNED NOT NULL auto_increment,
	  blog_id int(12) DEFAULT '0' NOT NULL, 
	  plugin_name VARCHAR(64) NOT NULL DEFAULT '',
	  theme_name VARCHAR(64) NOT NULL DEFAULT '',
	  option_name VARCHAR(64) NOT NULL DEFAULT '',
	  option_value longtext NOT NULL,
	  PRIMARY KEY (id, blog_id, option_name),
	  KEY option_name (option_name),
	  KEY plugin_name (plugin_name),
	  KEY theme_name (theme_name)
	);";
dbDelta($sql);
add_option("drf_wp_db_version", $drf_wp_db_version);
}

// Upgrade if new version 
$installed_ver = get_option( "drf_wp_db_version" );
if( $installed_ver != $drf_wp_db_version ) {
dbDelta($sql);
$sql = "CREATE TABLE " . $table_name . " (
	  id bigint(20) UNSIGNED NOT NULL auto_increment,
	  blog_id int(12) DEFAULT '0' NOT NULL, 
	  plugin_name VARCHAR(64) NOT NULL DEFAULT '',
 	  theme_name VARCHAR(64) NOT NULL DEFAULT '',
	  option_name VARCHAR(64) NOT NULL DEFAULT '',
	  option_value longtext NOT NULL,
	  PRIMARY KEY (id, blog_id, option_name),
	  KEY option_name (option_name),
	  KEY plugin_name (plugin_name),
	  KEY theme_name (theme_name)
	);";
dbDelta($sql);
update_option("drf_wp_db_version", $drf_wp_db_version);
}
// End Install
?>