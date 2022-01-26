<?php
/*
 * Template Name: Blank Email Template
 * Template Post Type: ucf_email
 * Description: Blank template used to create an email.
 */
?>

<?php
  the_post();
?>

<?php include_once( 'header.php' ); ?>

<?php
$content = get_block_email_content();

if ( $content ) {
	foreach ( $content as $row ) {
		echo block_display_row( $row );
	}
}
?>

<?php include_once( 'footer.php' ); ?>
