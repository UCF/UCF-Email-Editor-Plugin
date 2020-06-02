<?php
/**
 * Provides the functions necessary for instantly
 * sending email markup
 */

/**
 * Properly formats incoming arguments
 * to send an email from WordPress
 * @author Jim Barnes
 * @since 1.2.0
 * @param array $args The argument array
 * @return bool True if the email was sent.
 */
function send_instant_preview( $args ) {
	$args = shortcode_atts(
		array(
			'to'            => array( 'webcom@ucf.edu' ),
			'subject'       => '**PREVIEW** Test Email **PREVIEW**',
			'from_friendly' => 'Good Morning UCF Admin',
			'from'          => 'webcom@ucf.edu',
			'body'          => 'Hello World',
		),
		$args
	);

	$headers = array();

	$from_friendly = $args['from_friendly'];
	$from_email    = $args['from'];

	$sender = "From: $from_friendly <$from_email>";

	$headers[] = $sender;
	$headers[] = 'Content-Type: text/html; charset=UTF-8';

	// DEBUG REMEMBER TO REMOVE!
	$args['to'] = array( 'james.barnes@ucf.edu' );

	return wp_mail(
		$args['to'],
		$args['subject'],
		$args['body'],
		$headers
	);
}

/**
 * Generates markup for an email based
 * on the email id
 * @author Jim Barnes
 * @since 1.2.0
 * @param int $post_id
 * @return string
 */
function generate_email_markup( $post_id ) {
	$args = array(
		'id' => $post_id
	);

	$query = new WP_Query( $args );

	ob_start();

	while ( $query->have_posts() ) : $query->the_post();

	include UCF_EMAIL_EDITOR__PLUGIN_DIR . 'templates/blank/blank-template.php';

	endwhile;

	wp_reset_postdata();

	return ob_get_clean();
}

/**
 * The ajax handlers for the instant send.
 * @author Jim Barnes
 * @since 1.2.0
 */
function instant_send_ajax() {
	$post_id = intval( $_POST['post_id'] );

	$markup = generate_email_markup( $post_id );

	$args = array(
		'body' => $markup
	);

	$send = send_instant_preview( $args );

	$retval = array(
		'success' => $send
	);

	echo json_encode( $retval );

	wp_die();
}

add_action( 'wp_ajax_instant-send', 'instant_send_ajax', 10 );
