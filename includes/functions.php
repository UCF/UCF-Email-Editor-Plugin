<?php
/**
 * Filter to convert content paragraphs into email friendly tables
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function convert_content_to_email_markup( $content ) {
	if ( get_query_var( 'post_type' ) !== 'ucf-email' ) {
		return $content;
	}

	ob_start();
	?>
		<table class="paragraphtable" style="width: 100%;">
			<tbody>
				<tr>
					<td class="montserratlight" style="width: 100%; font-family: Helvetica, Arial, sans-serif; padding: 0px 0px 16px 0px; margin: 0;">
	<?php
	$table_open = ob_get_clean();

	ob_start();
	?>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
	$table_close = ob_get_clean();

	$ul = '<ul style="margin-top:0;margin-bottom:0;padding-bottom:0;">';
	$ol = '<ol style="margin-top:0;margin-bottom:0;padding-bottom:0;">';
	$li = '<li style="margin-bottom:5px;">';

	$content = preg_replace('/<p[^>]*>/', $table_open, $content);
	$content = preg_replace('/<\/p>/', $table_close, $content);

	$content = preg_replace('/<ul[^>]*>/', $table_open . $ul, $content);
	$content = preg_replace('/<\/ul>/', '</ul>' . $table_close, $content);

	$content = preg_replace('/<ol[^>]*>/', $table_open . $ol, $content);
	$content = preg_replace('/<\/ol>/', '</ol>' . $table_close, $content);

	$content = preg_replace('/<li[^>]*>/', $li, $content);

	$content = preg_replace('/<section[^>]*>/', '', $content);
	$content = preg_replace('/<\/section>/', '', $content);

	$content = htmlspecialchars_decode( htmlentities( $content ) );

	return $content;
}

add_filter( 'the_content', 'convert_content_to_email_markup', 99 );

/**
 * Disable the WYSIWYG editor for UCF Section Post Type
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function gmucf_disable_section_wysiwyg( $wp_rich_edit ) {
	$screen = get_current_screen();

	if ( isset( $screen->post_type ) && $screen->post_type === 'ucf_section' ) {
		$wp_rich_edit = false;
	}

	return $wp_rich_edit;
}

add_filter( 'user_can_richedit', 'gmucf_disable_section_wysiwyg', 50 );
?>
