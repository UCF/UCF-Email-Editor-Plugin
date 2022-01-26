<?php

/**
 * Returns all email content data from the
 * currently queried object.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @return object|false
 */
function block_get_email_content() {
	$object_id = get_queried_object_id();
	$content   = get_field( 'email_content', $object_id );
	if ( ! $content  ) return false;

	return json_decode( json_encode( $content ) );
}


/**
 * Displays either a one-column or two-column row
 * of email content.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @param object $row Row of email content data
 * @return void
 */
function block_display_row( $row ) {
	$row_type = 'one_column_row';
	if ( isset( $row->acf_fc_layout ) && $row->acf_fc_layout === 'two_column_row' ) {
		$row_type = 'two_column_row';
	}

	// Pass along $row data to the template part:
	set_query_var( 'block_email_current_row', $row );

	include( UCF_EMAIL_EDITOR__PLUGIN_DIR . "templates/block/template-parts/rows/$row_type.php" );

	// Clean up afterwards:
	set_query_var( 'block_email_current_row', false );
}


/**
 * Returns a component template part for the provided
 * row of email content.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @param object $row Row of email content data
 * @param string $row_type Type of row that this component is being displayed in
 * @return void
 */
function block_display_component( $row, $row_type='one_column_row' ) {
	$component = $row->acf_fc_layout ?? '';
	if ( ! $component ) return;

	// Make row-specific adjustments as necessary:
	if ( $row_type === 'two_column_row' && $component === 'article' ) {
		$component = 'article_sm';
	}
	else if ( $row_type === 'two_column_row' && $component === 'image' ) {
		$component = 'image_sm';
	}

	// Pass along $row data to the template part:
	set_query_var( 'block_email_current_row', $row );

	include( UCF_EMAIL_EDITOR__PLUGIN_DIR . "templates/block/template-parts/components/$component.php" );

	// Clean up afterwards:
	set_query_var( 'block_email_current_row', false );
}


/**
 * Returns data for the current row being looped through.
 * For use in row and component template parts.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @return object
 */
function block_get_current_row() {
	return get_query_var( 'block_email_current_row' );
}


/**
 * Format WYSIWYG-generated paragraph content for use in
 * block email HTML.
 *
 * Utilizes functions defined in the UCF Email Editor plugin.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @param string $content Arbitrary HTML string
 * @return string Formatted content
 */
function block_format_paragraph_content( $content ) {
	$utm_params = block_get_utm_params();

	$content = convert_p_tags( $content );
	$content = convert_list_tags( $content, 'ul' );
	$content = convert_list_tags( $content, 'ol' );
	$content = convert_li_tags( $content );
	$content = convert_heading_tags( $content, 'h2', '24px' );
	$content = convert_heading_tags( $content, 'h3', '18px' );
	$content = apply_link_utm_params( $content, $utm_params['source'], $utm_params['medium'], $utm_params['campaign'], $utm_params['content'] );
	$content = block_escape_chars( $content );

	return $content;
}


/**
 * Formats WYSIWYG-generated deck content for use
 * in the block template HTML.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @param string $content Arbitrary HTML string
 * @return string Formatted content
 */
function block_format_deck_content( $content ) {
	// Strip <p> tags entirely (no replacement, since decks may
	// be wrapped within a link)
	$content = preg_replace( '/<p[^>]*>/', '', $content );
	$content = preg_replace( '/<\/p>/', '', $content );

	$content = block_escape_chars( $content );

	return $content;
}


/**
 * Generates the opening tag for an HTML heading.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @param string $font_size Font size to apply to the generated markup
 * @return string Email-safe heading markup
 */
function get_heading_open_markup( $font_size='24px' ) {
	ob_start();
?>
<table class="paragraphtable" style="width: 100%;">
	<tbody>
		<tr>
			<td style="font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; text-align: left; padding-bottom: 10px; font-size: <?php echo $font_size; ?>; font-weight: bold; line-height: 1.2;" align="left">
<?php
	return ob_get_clean();
}


/**
 * Converts heading tags to email-safe markup.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @param string $content Unmodified markup
 * @param string $heading_elem The heading element to replace (e.g. "h2", "h3")
 * @param string $font_size The font size to apply to the heading
 * @return string Modified email markup
 */
function convert_heading_tags( $content, $heading_elem, $font_size ) {
	$content = preg_replace( '/<' . $heading_elem .  '[^>]*>/', get_heading_open_markup( $font_size ), $content );
	$content = preg_replace( '/<\/' . $heading_elem .  '>/', get_table_close_markup(), $content );

	return $content;
}


/**
 * Escapes string content suitable for use in email HTML.
 *
 * @since 1.3.0
 * @author Jim Barnes
 * @param string Arbitrary string/HTML content
 * @return string Sanitized content
 */
function block_escape_chars( $content ) {
	return htmlspecialchars_decode( htmlentities( $content ) );
}

/**
 * Returns an array of utm parameters for
 * the currently queried object.
 * @author Jim Barnes
 * @since v1.3.0
 * @return array
 */
function block_get_utm_params() {
	$object_id = get_queried_object_id();

	$retval = array(
		'source'   => '',
		'medium'   => '',
		'campaign' => '',
		'content'  => ''
	);

	if ( ! get_field( 'email_enable_utms', $object_id ) ) {
		return $retval;
	}

	$retval['source']   = get_field( 'email_utm_source', $object_id );
	$retval['medium']   = get_field( 'email_utm_medium', $object_id );
	$retval['campaign'] = get_field( 'email_utm_campaign', $object_id );
	$retval['content']  = get_field( 'email_utm_content', $object_id );

	return $retval;
}
