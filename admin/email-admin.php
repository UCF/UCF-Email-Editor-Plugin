<?php
/**
 * Handles admin related functions
 */


function instant_sent_button( $post ) {
?>
<div class="misc-pub-section instant-send">
	<a style="margin-bottom: 12px;" class="preview button" href="/preview/" target="wp-preview-<?php echo $post->ID; ?>" id="instant-send">Send Preview</a>
</div>
<?php
}

add_action( 'post_submitbox_misc_actions', 'instant_sent_button', 10, 1 );
