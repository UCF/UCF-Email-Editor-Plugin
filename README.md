# UCF Email Editor Plugin #

WordPress Plugin to add an email editor for creating email html content.


## Description ##

Provides an Email custom post type, email templates for creating email HTML content.


## Documentation ##

Head over to the [UCF Email Editor Plugin wiki](https://github.com/UCF/UCF-Email-Editor-Plugin/wiki) for detailed information about this plugin, installation instructions, and more.


## Changelog ##

### 1.0.0 ###
* Initial release


## Upgrade Notice ##

n/a


## Development ##

Note that compiled, minified css and js {{edit this list if the plugin doesn't include css/js!}} files are included within the repo.  Changes to these files should be tracked via git (so that users installing the plugin using traditional installation methods will have a working plugin out-of-the-box.)

[Enabling debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file is recommended during development to help catch warnings and bugs.

### Requirements ###
* node
* gulp-cli

### Instructions ###
1. Clone the UCF-Email-Editor-Plugin repo into your local development environment, within your WordPress installation's `plugins/` directory: `git clone https://github.com/UCF/UCF-Email-Editor-Plugin.git`
2. `cd` into the new UCF-Email-Editor-Plugin directory, and run `npm install` to install required packages for development into `node_modules/` within the repo
3. Run `gulp default` to process front-end assets.
4. If you haven't already done so, create a new WordPress site on your development environment to test this plugin against.
5. Activate this plugin on your development WordPress site.
6. Configure plugin settings from the WordPress admin under "UCF Email Editor".

### Other Notes ###
* This plugin's README.md file is automatically generated. Please only make modifications to the README.txt file, and make sure the `gulp readme` command has been run before committing README changes.  See the [contributing guidelines](https://github.com/UCF/UCF-Email-Editor-Plugin/blob/master/CONTRIBUTING.md) for more information.


## Contributing ##

Want to submit a bug report or feature request?  Check out our [contributing guidelines](https://github.com/UCF/UCF-Email-Editor-Plugin/blob/master/CONTRIBUTING.md) for more information.  We'd love to hear from you!
