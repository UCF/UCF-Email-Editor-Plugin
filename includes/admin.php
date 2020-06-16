<?php

/**
 * Defines buttons that should be present in the first row
 * of WYSIWYG toolbars for email editing.
 *
 * @since 1.2.0
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
 * @since 1.2.0
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
 * @since 1.2.0
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
 * @since 1.2.0
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
 * @since 1.2.0
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
 * @since 1.2.0
 * @author Jo Dickson
 * @return array
 */
function mce_before_init_insert_formats( $settings ) {
	$settings['block_formats'] = 'Paragraph=p;Heading 2=h2';

	return $settings;
}

add_filter( 'tiny_mce_before_init', 'mce_before_init_insert_formats' );
