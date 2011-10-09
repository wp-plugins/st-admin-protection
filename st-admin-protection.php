<?php
/*
Plugin Name: ST Admin Protection
Plugin URI: http://mystickypost.com/groups/wordpress/forum/topic/st-admin-protection/
Description: This plugin blocks everyone but the admin from accessing the Wordpresss Admin
Version: 1.0.0
Author: Shayne Thiessen
Author URI: http://www.shaynethiessen.com/
*/

if (defined('WPBA_REQUIRED_CAPABILITY'))
	$wpba_required_capability = WPBA_REQUIRED_CAPABILITY;
if (defined('WPBA_REDIRECT_TO'))
	$wpba_redirect_to = WPBA_REDIRECT_TO;
if (!function_exists('wpba_init')) {
	function wpba_init() {
		global $wpba_required_capability, $wpba_redirect_to;
		
		// Is this the admin interface?
		if (
			stripos($_SERVER['REQUEST_URI'],'/wp-admin/') !== false
			&&
			stripos($_SERVER['REQUEST_URI'],'async-upload.php') == false
			&&
			stripos($_SERVER['REQUEST_URI'],'admin-ajax.php') == false
		) {
			if (!current_user_can($wpba_required_capability)) {
			// If you want to use this plugin on WPMU to stop all users accessing the admin interface, comment out the line above, uncomment the line below.
//			if (!is_site_admin()) {
				// Do we need to default to the site homepage?
				if ($wpba_redirect_to == '') { $wpba_redirect_to = get_option('siteurl'); }
				
				// Send a temporary redirect
				wp_redirect($wpba_redirect_to,302);
			}
		}
	}
}
add_action('init','wpba_init',0);

$wpba_required_capability = 'activate_plugins';
$wpba_redirect_to = '404.php';
?>