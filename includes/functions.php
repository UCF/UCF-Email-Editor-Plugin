<?php

/**
 * Returns table open email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function get_table_open_markup() {
	ob_start();
	?>
		<table class="paragraphtable" style="width: 100%;">
			<tbody>
				<tr>
					<td class="montserratlight" style="width: 100%; font-family: Helvetica, Arial, sans-serif; padding: 0px 0px 16px 0px; margin: 0;">
	<?php
	return ob_get_clean();
}


/**
 * Returns table close email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function get_table_close_markup() {
	ob_start();
	?>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
	return ob_get_clean();
}

/**
 * Returns h2 open email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function get_h2_open_markup() {
	ob_start();
	?>
		<table class="paragraphtable" style="width: 100%;">
			<tbody>
				<tr>
					<td class="montserratbold" style="width: 100%; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: bold; padding: 0px 0px 16px 0px; margin: 0;">
	<?php
	return ob_get_clean();
}

/**
 * Convert p tags to email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function convert_p_tags( $content ) {
	$content = preg_replace('/<p[^>]*>/', get_table_open_markup(), $content);
	$content = preg_replace('/<\/p>/', get_table_close_markup(), $content);

	return $content;
}

/**
 * Convert h2 tags to email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function convert_h2_tags( $content ) {
	$content = preg_replace('/<h2[^>]*>/', get_h2_open_markup(), $content);
	$content = preg_replace('/<\/h2>/', get_table_close_markup(), $content);

	return $content;
}

/**
 * Convert ul or ol tags to email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function convert_list_tags( $content, $type) {

	$ul = '<' . $type .  ' style="margin-top:0;margin-bottom:0;padding-bottom:0;">';

	$content = preg_replace('/<' . $type .  '[^>]*>/', get_table_open_markup() . $ul, $content);
	$content = preg_replace('/<\/' . $type .  '>/', '</' . $type .  '>' . get_table_close_markup(), $content);

	return $content;
}

/**
 * Convert li tags to email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function convert_li_tags( $content ) {

	$li = '<li style="margin-bottom:5px;">';

	$content = preg_replace('/<li[^>]*>/', $li, $content);

	return $content;
}

/**
 * Filter to convert content into email friendly markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 */
function convert_content_to_email_markup( $content ) {
	if ( get_query_var( 'post_type' ) !== 'ucf-email' ) {
		return $content;
	}

	$content = convert_p_tags( $content );
	$content = convert_h2_tags( $content );
	$content = convert_list_tags( $content, 'ul' );
	$content = convert_list_tags( $content, 'ol' );
	$content = convert_li_tags( $content );

	$content = preg_replace('/<section[^>]*>/', '', $content);
	$content = preg_replace('/<\/section>/', '', $content);

	$content = htmlspecialchars_decode( htmlentities( $content ) );

	return $content;
}

add_filter( 'the_content', 'convert_content_to_email_markup', 99 );


/**
* Filter to convert email header/title to email friendly markup
*
* @since 1.0.0
* @author RJ Bruneel
*/
function convert_title_to_email_markup( $title ) {
   if ( get_query_var( 'post_type' ) !== 'ucf-email' ) {
	   return $title;
   }

   return htmlspecialchars_decode( htmlentities( $title ) );
}

add_filter( 'the_title', 'convert_title_to_email_markup', 99 );
?>
