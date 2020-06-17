# UCF Email Editor Plugin #

WordPress Plugin to add an email editor for creating email html content.


## Description ##

Provides an Email custom post type, email templates for creating email HTML content.

The following templates can be overwritten in the plugin.

* blank-template.php


## Installation Requirements ##

This plugin is developed and tested against WordPress 4.9.7+ and PHP 5.4+.

### Required plugins ###
These plugins _must_ be activated for the UCF-Email-Editor-Plugin to function properly.

* [Advanced Custom Fields PRO](https://advancedcustomfields.com/)
* [UCF Section Plugin](https://github.com/UCF/UCF-Section-Plugin) v1.1.0+


## Configuration ##

After installing this plugin and [all necessary dependencies](#installation-requirements), you should perform the following configuration steps:

* [Download this plugin's ACF config file](https://github.com/UCF/UCF-Email-Editor-Plugin/blob/master/dev/acf-export.json), and import field groups using the ACF importer under Custom Fields > Tools.
* Create three new tags for Sections: "Email Header", "Email Signature", and "Email Footer".  Sections designated as email headers/signatures/footers should be assigned these tags, respectively.
* Modify plugin settings as necessary under Settings > UCF Email Editor.


## Changelog ##

### 1.1.6 ###
Enhancements:
* Added ability to hide the email title in the "blank" template.

### 1.1.5 ###
Bug Fixes:
* Fixed issue in "blank" template that could result in sporatic horizontal lines throughout the body of an email.

### 1.1.4 ###
Enhancements:
* Updated template to use a blank template instead of the leadership template.

### 1.1.3 ###
Enhancements:
* Refactored email markup filtering and added logic to convert `h2` tags to cross-client compatible markup.
* Added feature to select email signatures from an ACF dropdown field.
* Updated how custom webfonts are included in email markup to use a single, combined font definition, instead of definitions per each font weight.
* Removed unused styles/cruft.

### 1.1.2 ###
Documentation:
* Removed contributing doc and updated readme

### 1.1.1 ###
* Added filter to convert title to email safe html

### 1.1.0 ###
* Added logic to encode special characters
* Removed signatures

### 1.0.0 ###
* Initial release


## Upgrade Notice ##

n/a


## Development ##

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
* This plugin's README.md file is automatically generated. Please only make modifications to the README.txt file, and make sure the `gulp readme` command has been run before committing README changes.
