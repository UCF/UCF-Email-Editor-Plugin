<?php
/**
 * Filter for leadership email template.
 * @author RJ Bruneel
 * @since 1.0.0
 **/
function ucf_email_editor_leadership_template( $template ) {
	if ( get_query_var( 'post_type' ) === 'ucf-email' ) {
		// Look for a file in theme
		if ( ! locate_template( 'leadership-template.php' ) ) {
			$new_template = UCF_EMAIL_EDITOR__PLUGIN_DIR . 'templates/leadership/leadership-template.php';
			if ( file_exists( $new_template ) ) {
				return $new_template;
			}
		}
	}
	return $template;
}
add_filter( 'template_include', 'ucf_email_editor_leadership_template', 9 );
?>
