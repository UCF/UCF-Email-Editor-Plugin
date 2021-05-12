<?php

/**
 * Defines buttons that should be present in the first row
 * of WYSIWYG toolbars for email editing.
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @return array
 */
function email_wysiwyg_toolbar_r1() {
	return array(
		'formatselect',
		'bold',
		'italic',
		'bullist',
		'numlist',
		'link',
		'unlink',
		'pastetext',
		'removeformat',
		'charmap',
		'undo',
		'redo'
	);
}


/**
 * Defines buttons that should be present in the second row
 * of WYSIWYG toolbars for email editing.
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @return array
 */
function email_wysiwyg_toolbar_r2() {
	return array();
}


/**
 * Adds a custom ACF WYSIWYG toolbar called 'Email Markup' that
 * includes a simplified set of WYSIWYG tools that are supported by
 * this plugin
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @param array $toolbars Array of toolbar information from ACF
 * @return array
 */
function acf_email_wysiwyg_toolbar( $toolbars ) {
	$toolbars['Email Editor'] = array();
	$toolbars['Email Editor'][1] = email_wysiwyg_toolbar_r1();

	return $toolbars;
}

add_filter( 'acf/fields/wysiwyg/toolbars', 'acf_email_wysiwyg_toolbar' );


/**
 * Sets available buttons in the first row of the
 * Classic Editor's WYSIWYG toolbar.
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @return array
 */
function mce_email_wysiwyg_toolbar_r1( $buttons ) {
	global $post;
	if ( $post && $post instanceof WP_Post && $post->post_type === 'ucf-email' ) {
		$buttons = email_wysiwyg_toolbar_r1();
	}

	return $buttons;
}

add_filter( 'mce_buttons', 'mce_email_wysiwyg_toolbar_r1', 10, 1 );


/**
 * Sets available buttons in the second row of the
 * Classic Editor's WYSIWYG toolbar.
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @return array
 */
function mce_email_wysiwyg_toolbar_r2( $buttons ) {
	global $post;
	if ( $post && $post instanceof WP_Post && $post->post_type === 'ucf-email' ) {
		$buttons = email_wysiwyg_toolbar_r2();
	}

	return $buttons;
}

add_filter( 'mce_buttons_2', 'mce_email_wysiwyg_toolbar_r2', 10, 1 );


/**
 * Sets available block format options in the
 * Classic Editor WYSIWYG.
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @return array
 */
function mce_block_formats( $settings ) {
	global $post;
	if ( $post && $post instanceof WP_Post && $post->post_type === 'ucf-email' ) {
		$settings['block_formats'] = 'Paragraph=p;Heading 2=h2';
	}

	return $settings;
}

add_filter( 'tiny_mce_before_init', 'mce_block_formats' );


/**
 * Adds a paste_preprocess rule to the TinyMCE WYSIWYG editor that
 * applies a whitelist of HTML elements and strips out empty tags.
 *
 * @since 1.2.0
 * @author Jo Dickson
 * @param array $settings TinyMCE init config
 * @return array TinyMCE init config
 */
function mce_paste_preprocess( $settings ) {
	global $post;
	if (
		! $post
		|| ( $post && $post instanceof WP_Post && $post->post_type !== 'ucf-email' )
	) {
		return $settings;
	}

	ob_start();
?>
function(plugin, args) {
	var whitelist = [
		'p', 'a',
		'strong', 'em',
		'small', 'sup', 'sub',
		's', 'ins', 'del', 'abbr',
		'h2',
		'ul', 'li', 'ol'
	];

	// Generic function that replaces a URL with a query param value
	// based on specific search criteria in the URL
	function stripLinkPrefix(url, searchRegex, queryParam) {
		if (url.search(searchRegex) !== -1) {
			var dummylink = document.createElement('a');
			dummylink.href = url;
			var query = dummylink.search;
			var updatedUrl = '';
			if (query.indexOf(queryParam + '=') !== -1) {
				// Get the query param
				updatedUrl = query.replace('?', '').split('&').filter(function(x) { var kv = x.split('='); if (kv[0] === queryParam) return kv[1]; } ).shift().split('=')[1];

				// Decode special characters.
				// This is dumb, but colon (:) characters don't get
				// decoded properly without running decodeURIComponent()
				// on the string twice
				updatedUrl = decodeURIComponent(decodeURIComponent(updatedUrl));

				// Avoid &amp;amp; situations
				updatedUrl = updatedUrl.replace(/&amp;/g, '&');

				url = updatedUrl;
			}
		}

		return url;
	}

	// Replaces Outlook safelink URLs with the actual redirected URL
	function stripOutlookSafelinks(url) {
		return stripLinkPrefix(
			url,
			/^https\:\/\/(.*\.)safelinks\.protection\.outlook\.com\//i,
			'url'
		);
	}

	// Replaces Postmaster redirects with the actual redirected URL
	function stripPostmasterRedirects(url) {
		return stripLinkPrefix(
			url,
			/^https\:\/\/postmaster\.smca\.ucf\.edu\//i,
			'url'
		);
	}

	function sanitizeUrl(url) {
		return stripPostmasterRedirects(stripOutlookSafelinks(url));
	}

	var clean = sanitizeHtml(args.content, {
		allowedTags: whitelist,
		transformTags: {
			'b': 'strong',
			'i': 'em',
			'a': function(tagName, attribs) {
				if (attribs.href) {
					url = sanitizeUrl(attribs.href);
					if (url !== attribs.href) {
						attribs.href = url;
					}
				}

				return {
					tagName: tagName,
					attribs: attribs
				}
			}
		},
		exclusiveFilter: function(frame) {
			return (
				// Strip out empty tags
				!frame.text.trim()
			);
		}
	});

	// Return the clean HTML
	args.content = clean;
}
<?php
	$settings['paste_preprocess'] = ob_get_clean();

	return $settings;
}

add_filter( 'tiny_mce_before_init', 'mce_paste_preprocess' );


/**
 * Removes unsupported elements from the plaintext editor's
 * "quicktags" toolbar
 *
 * @since 1.1.7
 * @author Jo Dickson
 */
function email_quicktags_settings( $qt_settings, $editor_id ) {
	global $post;

	if (
		is_admin()
		&& $post instanceof WP_Post
		&& $post->post_type === 'ucf-email'
	) {
		$qt_settings['buttons'] = 'strong,em,link,img,ul,ol,li';
	}

	return $qt_settings;
}

add_filter( 'quicktags_settings', 'email_quicktags_settings', 10, 2 );


/**
 * Conditionally enqueues the sanitize-html lib on the
 * post edit screen.
 *
 * @since 1.2.0
 * @author Jo Dickson
 */
function admin_enqueue_sanitizehtml( $hook ) {
	$screen = get_current_screen();

	if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) ) {
		$screen = get_current_screen();
		if ( $screen instanceof WP_Screen && $screen->post_type === 'ucf-email' ) {
			wp_enqueue_script( 'ucf_email_editor_sanitizehtml', UCF_EMAIL_EDITOR__JS_URL . '/sanitize-html.min.js' );
		}
	}
}

add_action( 'admin_enqueue_scripts', 'admin_enqueue_sanitizehtml' );
