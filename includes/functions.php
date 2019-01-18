<?php
/**
 * Filter to convert content paragraphs into email friendly tables
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
add_filter( 'the_content', 'convert_content_to_email_markup' );
 function convert_content_to_email_markup( $content ) {
	if ( ! is_page_template( 'email-template-default.php' ) ) {
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

 	$content = preg_replace('/<p[^>]*>/', $table_open, $content);
	$content = preg_replace('/<\/p>/', $table_close, $content);

 	return $content;
}
?>
