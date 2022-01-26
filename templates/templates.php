<?php
/**
 * Filter for blank email template.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
function ucf_email_editor_blank_template( $template ) {
	// Make sure this is an email custom post type
	if ( get_query_var( 'post_type' ) !== 'ucf-email' ) return $template;

	// Makes sure we're on an individual/singular template
	if ( ! $post_id = get_queried_object_id() ) return $template;

	// Get the template from post meta
	$stored_template = get_post_meta( $post_id, '_wp_page_template', true );

	if ( $stored_template === 'block-template.php' ) {
		if ( ! locate_template( 'block-template.php' ) ) {
			$new_template = UCF_EMAIL_EDITOR__PLUGIN_DIR . 'templates/block/block-template.php';
			if ( file_exists( $new_template ) ) {
				return $new_template;
			}
		}
	} else {
		// Look for a file in theme
		if ( ! locate_template( 'blank-template.php' ) ) {
			$new_template = UCF_EMAIL_EDITOR__PLUGIN_DIR . 'templates/blank/blank-template.php';
			if ( file_exists( $new_template ) ) {
				return $new_template;
			}
		}
	}

	return $template;
}

add_filter( 'template_include', 'ucf_email_editor_blank_template', 10, 1 );

/**
 * Adds template options to emails
 * @author Jim Barnes
 * @since 2.0.0
 */
function ucf_email_editor_templates( $templates ) {
	return array(
		'block-template.php' => 'Block Template'
	);
}

add_filter( 'theme_ucf-email_templates', 'ucf_email_editor_templates', 10, 1 );

?>
