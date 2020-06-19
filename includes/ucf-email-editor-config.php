<?php
/**
 * Handles plugin configuration
 */
if ( !class_exists( 'UCF_Email_Editor_Config' ) ) {
	class UCF_Email_Editor_Config {
		public static
			$option_prefix = 'ucf_email_editor_',
			$option_defaults = array(
				'header_image'      => 'https://s3.amazonaws.com/web.ucf.edu/email/postmaster-templates/pro-banner.png',
				'utm_replace_regex' => '/^http(s)?\:\/\/([^\?\/]+\.)?ucf.edu(\/)?/i'
			);


		/**
		 * Creates options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run on plugin activation.
		 *
		 * @return void
		 **/
		public static function add_options() {
			$defaults = self::$option_defaults; // don't use self::get_option_defaults() here (default options haven't been set yet)
			add_option( self::$option_prefix . 'header_image', $defaults['header_image'] );
			add_option( self::$option_prefix . 'utm_replace_regex', $defaults['utm_replace_regex'] );
		}


		/**
		 * Deletes options via the WP Options API that are utilized by the
		 * plugin.  Intended to be run when plugin is uninstalled.
		 *
		 * @return void
		 **/
		public static function delete_options() {
			delete_option( self::$option_prefix . 'header_image' );
			delete_option( self::$option_prefix . 'utm_replace_regex' );
		}


		/**
		 * Returns an array with plugin defaults applied.
		 *
		 * @param array $list
		 * @param boolean $list_keys_only Modifies results to only return array key values present in $list.
		 * @return array
		 **/
		public static function apply_option_defaults( $list, $list_keys_only=false ) {
			$defaults = self::$option_defaults;
			$options = array();
			if ( $list_keys_only ) {
				foreach ( $list as $key => $val ) {
					$options[$key] = !empty( $val ) ? $val : $defaults[$key];
				}
			} else {
				$options = array_merge( $defaults, $list );
			}
			return $options;
		}


		/**
		 * Convenience method for returning an option from the WP Options API
		 * or a plugin option default.
		 *
		 * @param $option_name
		 * @return mixed
		 **/
		public static function get_option_or_default( $option_name ) {
			// Handle $option_name passed in with or without self::$option_prefix applied:
			$option_name_no_prefix = str_replace( self::$option_prefix, '', $option_name );
			$option_name = self::$option_prefix . $option_name_no_prefix;
			$option = get_option( $option_name );

			$option_formatted = self::apply_option_defaults( array(
				$option_name_no_prefix => $option
			), true );

			return $option_formatted[$option_name_no_prefix];
		}


		/**
		 * Initializes setting registration with the Settings API.
		 **/
		public static function settings_init() {
			// Register settings
			register_setting( 'ucf_email_editor', self::$option_prefix . 'header_image' );
			register_setting( 'ucf_email_editor', self::$option_prefix . 'utm_replace_regex' );

			// Register setting sections
			add_settings_section(
				'ucf_email_editor_section_general', // option section slug
				'General Settings', // formatted title
				'', // callback that echoes any content at the top of the section
				'ucf_email_editor' // settings page slug
			);

			// Register fields
			add_settings_field(
				self::$option_prefix . 'header_image',
				'Header Image',  // formatted field title
				array( 'UCF_Email_Editor_Config', 'display_settings_field' ), // display callback
				'ucf_email_editor',  // settings page slug
				'ucf_email_editor_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'header_image',
					'description' => 'URL of the image to be displayed in the header.',
					'type'        => 'image-url'
				)
			);
			add_settings_field(
				self::$option_prefix . 'utm_replace_regex',
				'UTM Replacement Regex Pattern',  // formatted field title
				array( 'UCF_Email_Editor_Config', 'display_settings_field' ), // display callback
				'ucf_email_editor',  // settings page slug
				'ucf_email_editor_section_general',  // option section slug
				array(  // extra arguments to pass to the callback function
					'label_for'   => self::$option_prefix . 'utm_replace_regex',
					'description' => 'Regex pattern to match URLs against in emails when inserting UTM params.',
					'type'        => 'text'
				)
			);
		}


		/**
		 * Displays an individual setting's field markup.
		 **/
		public static function display_settings_field( $args ) {
			$option_name   = $args['label_for'];
			$description   = $args['description'];
			$field_type    = $args['type'];
			$hidden        = isset( $args['hidden'] ) ? $args['hidden'] : false;
			$current_value = self::get_option_or_default( $option_name );
			$markup        = '';

			switch ( $field_type ) {
				case 'checkbox':
					ob_start();
				?>
					<input type="checkbox" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" <?php echo ( $current_value == true ) ? 'checked' : ''; ?>>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'number':
					ob_start();
				?>
					<input type="number" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;

				case 'image-url':
						ob_start();
					?>
					<img src="<?php echo $current_value; ?>">
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" class="large-text img-input" value="<?php echo $current_value; ?>">
						<p class="description">
							<?php echo $description; ?>
						</p>
					<?php
						$markup = ob_get_clean();
						break;

				case 'text':
				default:
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" class="regular-text" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
			}
		?>

		<?php
			echo $markup;
		}


		/**
		 * Registers the settings page to display in the WordPress admin.
		 **/
		public static function add_options_page() {
			$page_title = 'UCF Email Editor Settings';
			$menu_title = 'UCF Email Editor';
			$capability = 'manage_options';
			$menu_slug  = 'ucf_email_editor';
			$callback   = array( 'UCF_Email_Editor_Config', 'options_page_html' );

			return add_options_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);
		}


		/**
		 * Displays the plugin's settings page form.
		 **/
		public static function options_page_html() {
			ob_start();
		?>

		<script>
			let emailEditorImageDir = "<?php echo UCF_EMAIL_EDITOR__IMG_URL; ?>";
		</script>

		<div class="wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'ucf_email_editor' );
				do_settings_sections( 'ucf_email_editor' );
				submit_button();
				?>
			</form>
		</div>

		<?php
			echo ob_get_clean();
		}

	}
}
