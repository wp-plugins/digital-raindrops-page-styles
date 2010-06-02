=== Digital Raindrops Page Styles ===
Contributors: adeptris
Plugin URI: http://www.digitalraindrops.net/
Author: David Cox (email: david.cox@digitalraindrops.net)
Author URI: http://www.digitalraindrops.net/
Donation URI: http://www.digitalraindrops.net/
Demo URI: http://digitalraindrops.net/demo/wordpress/style-swapper/
Requires at least: 2.7
Tested up to: 2.9
Tags: styles, admin, pages, stylesheets, swapper, switcher, page style, css, templates
Stable tag: 0.1

== Description ==
Easy management of Page Styles per page allowing the blog administrator to set a different style for any page.
Just upload any theme variants to your themes folder, when you choose to swap a style for a page the Page Styles plugin reads the css file.
The Page Styles plugin does not load the whole theme it just loads the Style Sheet for changing colors and graphics.
This pluging does not hide content or sidebars, use theme layouts with the same look and feel.
It would be ideal to split you blog pages, you may want a different style for a section of ecommerce or support pages on you blog. 



== Installation ==

1. Download and unzip the package.
2. FTP the entire "drf-page-styles" directory to your /wp-content/plugins/ directory on your blog.
3. Activate the plugin on the "Plugins" tab of the administration panel.
4. This plugin uses the themes in your wp/wp-content/themes/ main directory.
5. Name and upload some theme variants you would like to swap to the themes folder.
5. Go to Appearance > Page Styles this will bring up an admin screen where you can select different themes per page.


== Upgrading ==

You may upgrade the plugin via the automated system in WordPress 2.5 or greater, or "old-style" by downloading the new one and then
1. Deactivating plugin
2. Uploading the updated files
3. Reactivating plugin



== Frequently Asked Questions ==
Q. Why are my Page Style selections not being saved?
A. This plugin will create a table in the database, this may have failed, on the admin page do the following
1. Deactivate the plugin
2. in the address bar where it says /wp-admin/ change this to /wp-admin/options.php
4. look for the entry drf_wp_db_version and delete the value, and save the changes
5. Activate the plugin again and test




== Screenshots ==
1. Admin Panel


== Known Issues ==
Table creation Problem has been fixed

== Support ==



== Translation Credits ==



== Changelog ==
* 1.0.0 - Initial release