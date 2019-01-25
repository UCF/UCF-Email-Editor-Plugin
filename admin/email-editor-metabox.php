<?php
/**
 * Handles creating the email editor metaboxes
 **/
if ( ! class_exists( 'UCF_Email_Editor_Metabox' ) ) {
	class UCF_Email_Editor_Metabox {


		/**
		 * Enqeues admin js
		 * @author RJ Bruneel
		 * @since 1.0.0
		 * @param $hook string | The current admin hook
		 **/
		public static function enqueue_admin_js( $hook ) {
			if ( 'settings_page_ucf_email_editor' === $hook ) {
				wp_enqueue_script(
					'ucf-email-editor-js',
					UCF_EMAIL_EDITOR__JS_URL . '/ucf-email-editor-admin.js',
					array( 'jquery' ),
					null,
					true
				);
			}
		}


		/**
		 * Adds the Custom Email Editor metabox
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function add_meta_box() {
			add_meta_box(
				'ucf-email-editor',
				__( 'Email Signature' ),
				array( 'UCF_Email_Editor_Metabox', 'metabox_markup' ),
				'ucf-email'
			);
		}


		/**
		 * The markup callback for the Email Editor metabox
		 * @author RJ Bruneel
		 * @since 1.0.0
		 * @param $post WP_Post | The current post object
		 * @return string | The function output is echoed
		 **/
		public static function metabox_markup( $post ) {
			wp_nonce_field(  'ucf_email_editor_nonce_save', 'ucf_email_editor_nonce' );
			$value = get_post_meta( $post->ID, 'ucf_email_editor_signature', true );
			$value = ( empty( $value ) ) ? 'president' : $value;
		?>
			<table class="form-table">
				<tbody>
					<tr>
						<th><strong>Select an Email Signature</strong></th>
						<td>
						<label for="president">
							<input type="radio" name="ucf_email_editor_signature" id="president" value="president" <?php checked( $value, 'president' ); ?> >President
						</label>
						&nbsp;
						<label for="provost">
							<input type="radio" name="ucf_email_editor_signature" id="provost" value="provost" <?php checked( $value, 'provost' ); ?> >Provost<br>
						</label>
						</td>
					</tr>
				</tbody>
			</table>
		<?php
		}


		/**
		 * Saves the data from the metabox
		 * @author RJ Bruneel
		 * @since 1.0.0
		 **/
		public static function save_metabox( $post_id ) {

			$post_type = get_post_type( $post_id );

			if (
				$post_type !== 'ucf-email' ||
				!isset( $_POST['ucf_email_editor_nonce'] )
				|| ! wp_verify_nonce( $_POST['ucf_email_editor_nonce'], 'ucf_email_editor_nonce_save' )
			) {
				return;
			}

			$new_meta_value = ( isset( $_POST['ucf_email_editor_signature'] ) ? sanitize_html_class( $_POST['ucf_email_editor_signature'] ) : '' );

			// Update the meta field in the database.
			update_post_meta( $post_id, 'ucf_email_editor_signature', $new_meta_value );

		}
	}
}
