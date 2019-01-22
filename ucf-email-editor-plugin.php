<?php
/*
Plugin Name: UCF Email Editor Plugin
Description: Provides email custom post type, email editor templates and related meta fields.
Version: 1.0.0
Author: UCF Web Communications
License: GPL3
GitHub Plugin URI: UCF/UCF-Email-Editor-Plugin
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'UCF_EMAIL_EDITOR__PLUGIN_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );
define( 'UCF_EMAIL_EDITOR__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UCF_EMAIL_EDITOR__PLUGIN_FILE', __FILE__ );

include_once 'includes/ucf-email-posttype.php';
include_once 'templates/templates.php';

if ( ! function_exists( 'ucf_email_editor_plugin_activation' ) ) {
	function ucf_email_editor_plugin_activation() {
		UCF_Email_PostType::register();
		flush_rewrite_rules();
	}
	register_activation_hook( UCF_EMAIL_EDITOR__PLUGIN_FILE, 'ucf_email_editor_plugin_activation' );
}

if ( ! function_exists( 'ucf_email_editor_plugin_deactivation' ) ) {
	function ucf_email_editor_plugin_deactivation() {
		flush_rewrite_rules();
	}
	register_deactivation_hook( UCF_EMAIL_EDITOR__PLUGIN_FILE, 'ucf_email_editor_plugin_deactivation' );
}


if ( ! function_exists( 'ucf_email_editor_plugins_loaded' ) ) {
	function ucf_email_editor_plugins_loaded() {
		add_action( 'init', array( 'UCF_Email_PostType', 'register' ), 10, 0 );
	}
	add_action( 'plugins_loaded', 'ucf_email_editor_plugins_loaded', 10, 0 );
}
?>
