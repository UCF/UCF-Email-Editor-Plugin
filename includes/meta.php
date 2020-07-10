<?php

/**
 * Returns a cache-busting param for use when enqueuing
 * this plugin's static assets in the WordPress admin.
 *
 * @since 1.1.10
 * @author Jo Dickson
 * @return string
 */
function ucf_email_editor_get_asset_cache_bust() {
	$cache_bust = '';

	// If debug mode is enabled, force editor stylesheets to
	// reload on every page refresh.  Caching of these stylesheets
	// is very aggressive
	if ( WP_DEBUG === true ) {
		$cache_bust = date( 'YmdHis' );
	}
	else {
		$plugin = get_plugin_data( UCF_EMAIL_EDITOR__PLUGIN_FILE );
		if ( isset( $plugin['Version'] ) ) {
			$cache_bust = $plugin['Version'];
		}
		else {
			$cache_bust = date( 'Ymd' );
		}
	}

	return $cache_bust;
}


/**
 * Adds editor styles for the Email post type
 * with cache-busting enabled.
 *
 * Themes/plugins should use this function when
 * defining custom TinyMCE styles for Emails outside
 * of the WordPress admin.
 *
 * @since 1.1.10
 * @author Jo Dickson
 * @return void
 */
function ucf_email_editor_enqueue_email_wysiwyg_styles() {
	$cache_bust = ucf_email_editor_get_asset_cache_bust();
	return add_editor_style( UCF_EMAIL_EDITOR__CSS_URL . '/editor-ucf-email.min.css?v=' . $cache_bust );
}


/**
 * Enqueue admin styles/scripts
 *
 * @since 1.1.10
 * @author Jo Dickson
 * @return void
 */
function ucf_email_editor_enqueue_admin_assets() {
	// get_current_screen() returns null on this hook,
	// so sniff the request URI instead when is_admin() is true
	if ( is_admin() ) {

		// Enqueue Email WYSIWYG stylesheet on New Post screen
		if (
			stristr( $_SERVER['REQUEST_URI'], 'post-new.php' ) !== false
			&& isset( $_GET['post_type'] )
			&& $_GET['post_type'] === 'ucf-email'
		) {
			// Remove any existing editor stylesheets, if present
			remove_editor_styles();
			// Add our styles
			ucf_email_editor_enqueue_email_wysiwyg_styles();
		}
		// Enqueue Email WYSIWYG stylesheet on Edit Post screen
		else if ( stristr( $_SERVER['REQUEST_URI'], 'post.php' ) !== false ) {
			global $post;
			if ( is_object( $post ) && get_post_type( $post->ID ) === 'ucf-email' ) {
				// Remove any existing editor stylesheets, if present
				remove_editor_styles();
				// Add our styles
				ucf_email_editor_enqueue_email_wysiwyg_styles();
			}
		}

	}
}

add_action( 'init', 'ucf_email_editor_enqueue_admin_assets', 99 ); // Enqueue late to ensure logic happens after Athena SC Plugin (if activated)
add_action( 'pre_get_posts', 'ucf_email_editor_enqueue_admin_assets' ); // Also register on this hook for Edit Post view, so that $post is defined at the correct time
