<?php

/**
 * Returns table open email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 * @return string table markup
 */
function get_table_open_markup() {
	ob_start();
	?>
		<table class="paragraphtable" style="width: 100%;">
			<tbody>
				<tr>
					<td style="width: 100%; font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; padding: 0px 0px 16px 0px; margin: 0;">
	<?php
	return ob_get_clean();
}


/**
 * Returns table close email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 * @return string table markup
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
 * @return string table markup
 */
function get_h2_open_markup() {
	ob_start();
	?>
		<table class="paragraphtable" style="width: 100%;">
			<tbody>
				<tr>
					<td style="width: 100%; font-family: 'UCF-Sans-Serif-Alt', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: bold; padding: 0px 0px 16px 0px; margin: 0;">
	<?php
	return ob_get_clean();
}


/**
 * Convert p tags to email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 * @param string $content
 * @return string content
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
 * @param string $content
 * @return string content
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
 * @param string $content
 * @param string $type
 * @return string content
 */
function convert_list_tags( $content, $type ) {
	// Sanity check on $type value before proceeding
	if ( ! in_array( $type, array( 'ul', 'ol' ) ) ) {
		$type = 'ul';
	}

	$dom        = get_dom_from_html_snippet( $content );
	$table_dom  = get_dom_from_html_snippet( get_table_open_markup() . get_table_close_markup() );
	$table_node = $table_dom->getElementsByTagName( 'table' )[0];

	foreach ( $dom->getElementsByTagName( $type ) as $elem ) {
		// Assign inline styles to all list elements.
		// Styles vary depending on if the list is a
		// nested list:
		$css_styles = $dom->createAttribute( 'style' );

		// Wrap all outermost lists in a paragraph table:
		if ( $elem->parentNode->nodeName !== 'li' ) {
			// Append top-level list styles first:
			$css_styles->value = 'margin-top:0;margin-bottom:10px;padding-bottom:0;';
			$elem->appendChild( $css_styles );

			// Get a new paragraph table node object:
			$repl_table = $dom->importNode( $table_node->cloneNode( true ), true );

			// Clone the list so we can copy its contents into
			// the paragraph table:
			$repl_table_content = $elem->cloneNode( true );

			// Get the inner <td> of the paragraph table node,
			// and add the copied list element to it:
			$repl_table_td = $repl_table->getElementsByTagName( 'td' )[0];
			$repl_table_td->appendChild( $repl_table_content );

			// Finally, replace the list element with the
			// new paragraph table:
			$elem->parentNode->replaceChild( $repl_table, $elem );
		}
		// For nested lists, just modify styles:
		else {
			$css_styles->value = 'margin-top:10px;margin-bottom:5px;padding-top:0;padding-bottom:0;';
			$elem->appendChild( $css_styles );
		}
	}

	$str = get_snippet_html_from_dom( $dom );
	if ( $str ) {
		$content = $str;
	}

	return $content;
}


/**
 * Convert li tags to email markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
 * @param string $content
 * @return string content
 */
function convert_li_tags( $content ) {

	$li = '<li style="margin-top:5px;margin-bottom:10px;padding-top:0;padding-bottom:0;">';

	$content = preg_replace('/<li[^>]*>/', $li, $content);

	return $content;
}


/**
 * Given an arbitrary partial string of HTML, returns
 * a DOMDocument object with that HTML loaded into it
 * with correct character encoding.
 *
 * Assumes $html is an HTML snippet, not a complete
 * HTML document (has no <html> or <body> tags).
 *
 * @since 1.1.11
 * @author Jo Dickson
 * @param string $html Arbitrary partial HTML string
 * @return DOMDocument
 */
function get_dom_from_html_snippet( $html ) {
	$dom = new DOMDocument();
	// Dumb hack that enforces correct character encoding
	// for DomDocument->loadHTML().
	$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
	return $dom;
}


/**
 * Given a DOMDocument object, returns its HTML
 * as a string.
 *
 * Removes wrapper `<body>` tags around the generated
 * HTML, so it's assumed that whatever HTML was loaded
 * into the DOMDocument was a snippet of HTML, and not
 * a complete HTML document (has no <html> or <body> tags).
 *
 * @since 1.1.11
 * @author Jo Dickson
 * @param DOMDocument a DOMDocument with an HTML snippet already loaded into it
 * @return string HTML snippet string
 */
function get_snippet_html_from_dom( $dom ) {
	// Make sure `$dom->saveHTML()` doesn't return false:
	$str = $dom->saveHTML() ?: '';

	$start = strpos( $str, '<body>' ) + 6;
	$end   = strpos( $str, '</body>' ) - strlen( $str );

	if ( $str ) {
		$str = substr( $str, $start, $end );
	}

	return $str;
}


/**
 * Returns the provided URL formatted with provided UTM params.
 *
 * Respects existing query params in the URL, but replaces
 * existing UTM params if present.
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @param string $url Arbitrary URL
 * @param string $source Source UTM param to insert
 * @param string $medium Medium UTM param to insert
 * @param string $campaign Campaign UTM param to insert
 * @param string $content Content UTM param to insert
 * @return string formatted URL
 */
function format_url_utm_params( $url='', $source='', $medium='', $campaign='', $content='' ) {
	// Make sure $url is a sane value
	if ( ! trim( $url ) ) return $url;

	// Require that at least $source, $medium and $campaign
	// be set to non-empty values:
	if ( ! trim( $source ) || ! trim( $medium ) || ! trim( $campaign ) ) {
		return $url;
	}

	// Segment out parts of the URL we need:
	$url_base = explode( '?', $url, 2 )[0] ?? $url; // strip query params from url
	$url_params_str = '';
	$url_params_arr = array();
	$url_anchor     = parse_url( $url, PHP_URL_FRAGMENT );
	if ( $url_anchor ) {
		$url_anchor = '#' . $url_anchor;
		$url_base = explode( '#', $url_base, -1 )[0] ?? $url_base; // strip anchor from url
	}

	// Parse out query params into an associative array,
	// apply our UTM params, then rebuild into a string:
	parse_str( parse_url( $url, PHP_URL_QUERY ), $url_params_arr );
	$url_params_arr['utm_source'] = $source;
	$url_params_arr['utm_medium'] = $medium;
	$url_params_arr['utm_campaign'] = $campaign;
	if ( $content ) {
		$url_params_arr['utm_content'] = $content;
	}
	else if ( isset( $url_params_arr['utm_content'] ) ) {
		unset( $url_params_arr['utm_content'] );
	}
	$url_params_str = '?' . http_build_query( $url_params_arr );

	// Put it all back together, and return:
	return $url_base . $url_params_str . $url_anchor;
}


/**
 * Applies UTM params to links within the provided content
 * using the regex pattern provided via plugin options.
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @param string $str Arbitrary partial HTML string
 * @param string $source Source UTM param to insert
 * @param string $medium Medium UTM param to insert
 * @param string $campaign Campaign UTM param to insert
 * @param string $content Content UTM param to insert
 * @return string Modified HTML string
 */
function apply_link_utm_params( $str, $source='', $medium='', $campaign='', $content='' ) {
	// Require that at least $source, $medium and $campaign
	// be set to non-empty values:
	if ( ! trim( $source ) || ! trim( $medium ) || ! trim( $campaign ) ) {
		return $str;
	}

	$pattern = UCF_Email_Editor_Config::get_option_or_default( 'utm_replace_regex' );

	if ( $pattern ) {
		$dom = get_dom_from_html_snippet( $str );

		foreach ( $dom->getElementsByTagName( 'a' ) as $elem ) {
			$href = $elem->getAttribute( 'href' );
			if ( preg_match( $pattern, $href ) ) {
				$elem->setAttribute(
					'href',
					format_url_utm_params(
						$href,
						$source,
						$medium,
						$campaign,
						$content
					)
				);
			}
		}

		$modified_str = get_snippet_html_from_dom( $dom );
		if ( $modified_str ) {
			$str = $modified_str;
		}
	}

	return $str;
}


/**
 * Applies UTM params to links within the provided content
 * using the regex pattern provided via plugin options.
 *
 * Assumes that the current global post metadata for an email
 * should be referenced when retrieving UTM params to apply.
 *
 * @since 1.1.7
 * @author Jo Dickson
 * @param string $str Arbitrary HTML string
 * @return string Modified HTML string
 */
function apply_email_link_utm_params( $str ) {
	global $post;
	if ( ! $post || ! $post instanceof WP_Post || $post->post_type !== 'ucf-email' ) return $str;

	$do_utm_replacments = get_field( 'email_enable_utms' );
	if ( $do_utm_replacments !== true ) return $str;

	$source   = get_field( 'email_utm_source' );
	$medium   = get_field( 'email_utm_medium' );
	$campaign = get_field( 'email_utm_campaign' );
	$content  = get_field( 'email_utm_content' );

	// Require that at least $source, $medium and $campaign
	// be set to non-empty values:
	if ( ! trim( $source ) || ! trim( $medium ) || ! trim( $campaign ) ) {
		return $str;
	}

	return apply_link_utm_params(
		$str,
		$source,
		$medium,
		$campaign,
		$content
	);
}


/**
 * Filter to convert content into email friendly markup
 *
 * @since 1.0.0
 * @author RJ Bruneel
* @param string $content
* @return string content
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

	$content = apply_email_link_utm_params( $content );

	return $content;
}

add_filter( 'the_content', 'convert_content_to_email_markup', 99 );


/**
* Filter to convert email header/title to email friendly markup
*
* @since 1.0.0
* @author RJ Bruneel
* @param string $title
* @return string email title
*/
function convert_title_to_email_markup( $title ) {
   if ( get_query_var( 'post_type' ) !== 'ucf-email' ) {
	   return $title;
   }

   return htmlspecialchars_decode( htmlentities( $title ) );
}

add_filter( 'the_title', 'convert_title_to_email_markup', 99 );


/**
* Get the selected email header
*
* @since 1.0.0
* @author RJ Bruneel
* @return string header markup
*/
function get_email_header() {

	$header = get_field( 'email_header' );

	if ( $header ) {
	  $header = apply_email_link_utm_params( $header->post_content );
	} else {
	  $header = '';
	}

	return $header;
}


/**
 * Get the selected email title
 *
 * @since 1.1.6
 * @author Jo Dickson
 * @return string email title
 */
function get_email_title() {
	$title = '';
	$hide_title = get_field( 'email_hide_title' );

	if ( $hide_title !== true ) {
		$title = get_the_title();
	}

	return $title;
}


/**
* Get the selected email signature
*
* @since 1.0.0
* @author RJ Bruneel
* @return string signature markup
*/
function get_email_signature() {

	$signature = get_field( 'email_signature' );

	if( $signature ) {
	  $signature = apply_email_link_utm_params( $signature->post_content );
	} else {
	  $signature = '';
	}

	return $signature;
}


/**
* Get the selected email footer
*
* @since 1.0.0
* @author RJ Bruneel
* @return string footer markup
*/
function get_email_footer() {

	$footer = get_field( 'email_footer' );

	if( $footer ) {
	  $footer = apply_email_link_utm_params( $footer->post_content );
	} else {
	  $footer = '';
	}

	return $footer;
}

?>
