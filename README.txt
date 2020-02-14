=== UCF Email Editor Plugin ===
Contributors: ucfwebcom
Requires at least: 4.9.7
Tested up to: 4.9.7
Stable tag: 0.0.0
Requires PHP: 5.4
License: GPLv3 or later
License URI: http://www.gnu.org/copyleft/gpl-3.0.html

WordPress Plugin to add an email editor for creating email html content.


== Description ==

Provides an Email custom post type, email templates for creating email HTML content.

The following templates can be overwritten in the plugin.

* leadership-template.php


== Documentation ==

Head over to the [UCF Email Editor Plugin wiki](https://github.com/UCF/UCF-Email-Editor-Plugin/wiki) for detailed information about this plugin, installation instructions, and more.


== Changelog ==

= 1.1.1 =
* Added filter to convert title to email safe html

= 1.1.0 =
* Added logic to encode special characters
* Removed signatures

= 1.0.0 =
* Initial release


== Upgrade Notice ==

n/a


== Development ==

[Enabling debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file is recommended during development to help catch warnings and bugs.

= Requirements =
* node
* gulp-cli

= Instructions =
1. Clone the UCF-Email-Editor-Plugin repo into your local development environment, within your WordPress installation's `plugins/` directory: `git clone https://github.com/UCF/UCF-Email-Editor-Plugin.git`
2. `cd` into the new UCF-Email-Editor-Plugin directory, and run `npm install` to install required packages for development into `node_modules/` within the repo
3. Run `gulp default` to process front-end assets.
4. If you haven't already done so, create a new WordPress site on your development environment to test this plugin against.
5. Activate this plugin on your development WordPress site.
6. Configure plugin settings from the WordPress admin under "UCF Email Editor".

= Other Notes =
* This plugin's README.md file is automatically generated. Please only make modifications to the README.txt file, and make sure the `gulp readme` command has been run before committing README changes.
