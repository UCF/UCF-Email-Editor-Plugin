<?php
/**
 * Handles admin related functions
 */


function instant_send_button( $post ) {
?>
<div class="misc-pub-section instant-send">
	<a style="margin-bottom: 12px;" class="preview button" href="#send-preview" id="instant-send">Send Preview</a>
</div>
<?php
}

add_action( 'post_submitbox_misc_actions', 'instant_send_button', 10, 1 );

function insert_instant_send_js() {
	global $post;

	if ( $post->post_type !== 'ucf-email' ) return;

?>
	<script>
		$post_id = <?php echo $post->ID; ?>;

		var data = {
			post_id: $post_id,
			action: 'instant-send'
		};

		var onPostSuccess = function(response) {
			var $markup = jQuery(
				'<div class="updated notice notice-success is-dismissible">' +
					'<p>Preview of email sent.</p>' +
				'</div>'
			);

			$markup.insertAfter('.wp-header-end');
		};

		jQuery('#instant-send').on('click', function() {
			jQuery.post(
				ajaxurl,
				data,
				onPostSuccess
			);
		});
	</script>
<?php
}

add_action( 'admin_footer-post.php', 'insert_instant_send_js', 10, 1 );
